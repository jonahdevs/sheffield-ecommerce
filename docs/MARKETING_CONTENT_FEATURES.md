# Marketing & Content Management Features Implementation Guide

This document outlines the implementation plan for marketing and content management features in Sheffield Africa e-commerce platform.

## Overview

The following features are planned and currently redirect to a "Coming Soon" page:

### Marketing Features
1. **Campaigns** - `/admin/marketing/campaigns`
2. **Coupons & Discounts** - `/admin/marketing/coupons`
3. **Newsletter** - `/admin/marketing/newsletter`

### Content Management Features
4. **Blog Posts** - `/admin/content/blog`
5. **FAQ Management** - `/admin/content/faq`
6. **Page Management** - `/admin/content/pages`

---

## 1. Marketing Campaigns

### Database Schema

```php
// Migration: create_campaigns_table.php
Schema::create('campaigns', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->enum('type', ['email', 'promotional', 'seasonal', 'flash_sale']);
    $table->enum('status', ['draft', 'scheduled', 'active', 'paused', 'completed'])->default('draft');
    $table->text('description')->nullable();
    $table->timestamp('starts_at')->nullable();
    $table->timestamp('ends_at')->nullable();
    $table->json('target_audience')->nullable(); // customer segments
    $table->json('settings')->nullable(); // campaign-specific settings
    $table->unsignedInteger('views')->default(0);
    $table->unsignedInteger('clicks')->default(0);
    $table->unsignedInteger('conversions')->default(0);
    $table->decimal('revenue_generated', 15, 2)->default(0);
    $table->timestamps();
    $table->softDeletes();
});
```

### Key Features
- Create email/promotional campaigns
- Schedule campaigns
- Target specific customer segments
- Track performance (views, clicks, conversions)
- A/B testing support
- Campaign templates

### Implementation Steps
1. Create Campaign model with relationships
2. Create campaign CRUD pages (index, create, edit)
3. Add campaign analytics dashboard
4. Integrate with email service (Mailgun/SendGrid)
5. Add campaign scheduling with Laravel Queue

---

## 2. Coupons & Discounts

### Database Schema

```php
// Migration: create_coupons_table.php
Schema::create('coupons', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique();
    $table->string('name');
    $table->text('description')->nullable();
    $table->enum('type', ['percentage', 'fixed_amount', 'free_shipping', 'buy_x_get_y']);
    $table->decimal('value', 10, 2); // percentage or amount
    $table->decimal('min_purchase_amount', 10, 2)->nullable();
    $table->decimal('max_discount_amount', 10, 2)->nullable();
    $table->unsignedInteger('usage_limit')->nullable(); // total uses
    $table->unsignedInteger('usage_limit_per_user')->nullable();
    $table->unsignedInteger('times_used')->default(0);
    $table->timestamp('starts_at')->nullable();
    $table->timestamp('expires_at')->nullable();
    $table->enum('status', ['active', 'inactive', 'expired'])->default('active');
    $table->json('applicable_products')->nullable(); // product IDs
    $table->json('applicable_categories')->nullable(); // category IDs
    $table->json('excluded_products')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

// Migration: create_coupon_usage_table.php
Schema::create('coupon_usage', function (Blueprint $table) {
    $table->id();
    $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('order_id')->constrained()->cascadeOnDelete();
    $table->decimal('discount_amount', 10, 2);
    $table->timestamp('used_at');
});
```

### Key Features
- Multiple discount types (percentage, fixed, free shipping)
- Usage limits (total and per user)
- Product/category restrictions
- Expiration dates
- Auto-apply coupons
- Coupon stacking rules

### Implementation Steps
1. Create Coupon model with validation
2. Create coupon CRUD pages
3. Integrate with checkout process
4. Add coupon validation logic
5. Create coupon usage tracking
6. Add bulk coupon generation

---

## 3. Newsletter Management

### Database Schema

```php
// Migration: create_newsletter_subscribers_table.php
Schema::create('newsletter_subscribers', function (Blueprint $table) {
    $table->id();
    $table->string('email')->unique();
    $table->string('name')->nullable();
    $table->enum('status', ['subscribed', 'unsubscribed', 'bounced'])->default('subscribed');
    $table->string('verification_token')->nullable();
    $table->timestamp('verified_at')->nullable();
    $table->timestamp('subscribed_at');
    $table->timestamp('unsubscribed_at')->nullable();
    $table->json('preferences')->nullable(); // topic preferences
    $table->string('source')->nullable(); // where they subscribed from
    $table->timestamps();
});

// Migration: create_newsletter_campaigns_table.php
Schema::create('newsletter_campaigns', function (Blueprint $table) {
    $table->id();
    $table->string('subject');
    $table->text('preview_text')->nullable();
    $table->longText('content'); // HTML content
    $table->enum('status', ['draft', 'scheduled', 'sending', 'sent'])->default('draft');
    $table->timestamp('scheduled_at')->nullable();
    $table->timestamp('sent_at')->nullable();
    $table->unsignedInteger('recipients_count')->default(0);
    $table->unsignedInteger('opened_count')->default(0);
    $table->unsignedInteger('clicked_count')->default(0);
    $table->unsignedInteger('bounced_count')->default(0);
    $table->timestamps();
});
```

### Key Features
- Subscriber management (import, export)
- Email templates with drag-and-drop builder
- Segmentation (by purchase history, location, etc.)
- A/B testing
- Analytics (open rate, click rate, conversions)
- Automated welcome emails
- GDPR compliance (double opt-in, easy unsubscribe)

### Implementation Steps
1. Create subscriber management system
2. Build email template editor (use TinyMCE or similar)
3. Integrate with email service provider
4. Add subscription forms to frontend
5. Create analytics dashboard
6. Implement automated campaigns

---

## 4. Blog Management

### Database Schema

```php
// Migration: create_blog_posts_table.php
Schema::create('blog_posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('excerpt')->nullable();
    $table->longText('content');
    $table->string('featured_image')->nullable();
    $table->foreignId('author_id')->constrained('users');
    $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');
    $table->timestamp('published_at')->nullable();
    $table->unsignedInteger('views')->default(0);
    $table->json('meta')->nullable(); // SEO meta tags
    $table->timestamps();
    $table->softDeletes();
});

// Migration: create_blog_categories_table.php
Schema::create('blog_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->timestamps();
});

// Pivot table
Schema::create('blog_post_category', function (Blueprint $table) {
    $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
    $table->foreignId('blog_category_id')->constrained()->cascadeOnDelete();
    $table->primary(['blog_post_id', 'blog_category_id']);
});

// Migration: create_blog_tags_table.php
Schema::create('blog_tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});

// Pivot table
Schema::create('blog_post_tag', function (Blueprint $table) {
    $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
    $table->foreignId('blog_tag_id')->constrained()->cascadeOnDelete();
    $table->primary(['blog_post_id', 'blog_tag_id']);
});
```

### Key Features
- Rich text editor (TinyMCE/CKEditor)
- Categories and tags
- Featured images
- SEO optimization (meta tags, slugs)
- Scheduled publishing
- Draft/Published status
- Author attribution
- Comments (optional)
- Related posts
- Social sharing

### Implementation Steps
1. Create blog models and relationships
2. Build admin CRUD pages
3. Integrate rich text editor
4. Create frontend blog pages
5. Add SEO features
6. Implement search functionality

---

## 5. FAQ Management

### Database Schema

```php
// Migration: create_faq_categories_table.php
Schema::create('faq_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->unsignedInteger('order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

// Migration: create_faqs_table.php
Schema::create('faqs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('faq_category_id')->constrained()->cascadeOnDelete();
    $table->string('question');
    $table->text('answer');
    $table->unsignedInteger('order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->unsignedInteger('views')->default(0);
    $table->unsignedInteger('helpful_count')->default(0);
    $table->unsignedInteger('not_helpful_count')->default(0);
    $table->timestamps();
});
```

### Key Features
- Category organization
- Drag-and-drop ordering
- Rich text answers
- Search functionality
- "Was this helpful?" feedback
- View tracking
- Active/inactive status

### Implementation Steps
1. Create FAQ models
2. Build admin CRUD pages
3. Add drag-and-drop ordering (Livewire Sortable)
4. Create frontend FAQ page
5. Implement search
6. Add feedback system

---

## 6. Page Management (CMS)

### Database Schema

```php
// Migration: create_pages_table.php
Schema::create('pages', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->longText('content');
    $table->string('template')->default('default'); // page template
    $table->enum('status', ['draft', 'published'])->default('draft');
    $table->boolean('show_in_menu')->default(false);
    $table->unsignedInteger('menu_order')->default(0);
    $table->json('meta')->nullable(); // SEO meta tags
    $table->timestamps();
    $table->softDeletes();
});
```

### Key Features
- Create custom pages (About, Contact, Terms, Privacy)
- Multiple page templates
- Rich text editor
- SEO optimization
- Menu integration
- Draft/Published status

### Implementation Steps
1. Create Page model
2. Build admin CRUD pages
3. Create page templates
4. Add frontend routing
5. Implement SEO features

---

## Implementation Priority

### Phase 1 (High Priority)
1. **Coupons & Discounts** - Direct revenue impact
2. **FAQ Management** - Reduces support burden

### Phase 2 (Medium Priority)
3. **Page Management** - Essential for legal pages
4. **Newsletter** - Customer engagement

### Phase 3 (Lower Priority)
5. **Blog Management** - SEO and content marketing
6. **Marketing Campaigns** - Advanced marketing

---

## Technical Considerations

### Packages to Consider
- **Rich Text Editor**: `tinymce/tinymce` or `ckeditor/ckeditor5`
- **Email Service**: `mailgun/mailgun-php` or `sendgrid/sendgrid`
- **Drag & Drop**: `livewire-ui/sortable`
- **SEO**: `spatie/laravel-sitemap`
- **Analytics**: Custom implementation or `spatie/laravel-analytics`

### Performance Optimization
- Cache frequently accessed content (FAQs, pages)
- Use Redis for coupon validation
- Queue newsletter sending
- Optimize blog post queries with eager loading

### Security Considerations
- Sanitize user input in rich text editors
- Rate limit coupon validation
- Implement CSRF protection
- Add honeypot fields to newsletter forms
- Validate email addresses

---

## Next Steps

1. Review this implementation plan
2. Prioritize features based on business needs
3. Create detailed user stories for each feature
4. Set up development timeline
5. Begin with Phase 1 features

---

## Routes Summary

All routes are currently configured and redirect to the coming soon page:

```php
// Marketing
admin.marketing.campaigns.index
admin.marketing.coupons.index
admin.marketing.newsletter.index

// Content
admin.content.blog.index
admin.content.faq.index
admin.content.pages.index
```

To implement a feature, replace the redirect with a Livewire route:
```php
Route::livewire('/campaigns', 'pages::admin.marketing.campaigns.index')->name('campaigns.index');
```
