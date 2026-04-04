<?php

namespace App\Observers;

use App\Enums\ReviewStatus;
use App\Models\Review;
use App\Models\User;
use App\Notifications\NewReviewNotification;
use App\Settings\NotificationSettings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ReviewObserver
{
    public function __construct(
        private readonly NotificationSettings $notificationSettings
    ) {}

    public function created(Review $review): void
    {
        $this->syncProductRating($review);
        $this->notifyAdminStaff($review);
    }

    public function updated(Review $review): void
    {
        // Recalculate whenever status changes (pending → approved / rejected etc.)
        if ($review->wasChanged('status') || $review->wasChanged('rating')) {
            $this->syncProductRating($review);
        }
    }

    public function deleted(Review $review): void
    {
        $this->syncProductRating($review);
    }

    // -------------------------------------------------------------------------

    /**
     * Recalculate and persist average_rating + reviews_count from approved reviews.
     */
    private function syncProductRating(Review $review): void
    {
        $product = $review->product;

        if (! $product) {
            return;
        }

        $approved = $product->reviews()->where('status', ReviewStatus::APPROVED->value);

        $product->update([
            'average_rating' => round((float) ($approved->avg('rating') ?? 0), 2),
            'reviews_count' => $approved->count(),
        ]);
    }

    /**
     * Notify staff users so the database channel populates the notification dropdown.
     */
    private function notifyAdminStaff(Review $review): void
    {
        if (! $this->notificationSettings->notify_new_review) {
            return;
        }

        try {
            $staffUsers = User::staff()->get();

            Notification::send($staffUsers, new NewReviewNotification($review));

            Log::info('New review notification sent to admin staff', [
                'review_id' => $review->id,
                'product_id' => $review->product_id,
                'staff_count' => $staffUsers->count(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send new review notification to admin', [
                'review_id' => $review->id,
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
