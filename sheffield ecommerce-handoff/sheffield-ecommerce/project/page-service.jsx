// Sheffield — Service page. Direction-aware (editorial / workshop).
// After-sales: capabilities, maintenance plans, engineer-callout booking, regional coverage.
// Uses shared tokens, .input/.select/.btn/.chip classes, SHEFFIELD_LOCATIONS, the Field helper pattern.

const SERVICE_CAPABILITIES = [
  {
    icon: IconClock,
    title: "Preventive maintenance",
    desc: "Scheduled service visits that catch wear before it becomes a breakdown — fryers, ovens, refrigeration and dishwash.",
  },
  {
    icon: IconWrench,
    title: "Breakdown repair",
    desc: "Engineers dispatched to your kitchen with a stocked van. Most common faults fixed on the first visit.",
  },
  {
    icon: IconCog,
    title: "Genuine OEM spares",
    desc: "Original parts for Rational, Hobart, Williams and more — held in-country, not waiting on a six-week import.",
  },
  {
    icon: IconTruck,
    title: "Installation & commissioning",
    desc: "Delivery, siting, gas and electrical connection, calibration and a documented handover before you cook.",
  },
  {
    icon: IconShield,
    title: "Gas & electrical safety",
    desc: "Annual gas soundness tests, electrical inspection and certification to keep you compliant and insured.",
  },
  {
    icon: IconCertified,
    title: "Operator training",
    desc: "On-site sessions so your team runs equipment correctly — fewer faults, longer life, better food.",
  },
];

const SERVICE_PLANS = [
  {
    key: "callout",
    name: "Pay-as-you-go",
    tagline: "Callout when you need it",
    price: "from KES 6,500",
    priceNote: "per callout + parts",
    cta: "Book a callout",
    features: [
      "On-demand engineer dispatch",
      "Standard 48-hour response",
      "Genuine parts at list price",
      "90-day workmanship warranty",
      "Telephone diagnostics",
    ],
    featured: false,
  },
  {
    key: "care",
    name: "Sheffield Care",
    tagline: "Planned cover, fewer surprises",
    price: "from KES 48,000",
    priceNote: "per year, per site",
    cta: "Start a Care plan",
    features: [
      "2 preventive visits a year",
      "Priority 24-hour response",
      "10% off all genuine parts",
      "Annual gas & electrical check",
      "Service history & compliance log",
      "Dedicated account engineer",
    ],
    featured: true,
  },
  {
    key: "careplus",
    name: "Sheffield Care+",
    tagline: "Maximum uptime for high-volume kitchens",
    price: "Custom",
    priceNote: "tailored to your fleet",
    cta: "Talk to projects",
    features: [
      "Quarterly preventive visits",
      "4-hour emergency response, 24/7",
      "20% off genuine parts",
      "Loan equipment during major repairs",
      "Multi-site dashboard & reporting",
      "Named engineering team",
    ],
    featured: false,
  },
];

const EQUIPMENT_TYPES = [
  "Cooking (oven, range, fryer)",
  "Refrigeration & cold room",
  "Dishwash & warewashing",
  "Food prep & mixers",
  "Ventilation & extraction",
  "Other / not sure",
];

const URGENCY = [
  { key: "planned", label: "Planned", desc: "Maintenance or non-urgent" },
  { key: "soon", label: "Soon", desc: "Affecting service" },
  { key: "down", label: "Kitchen down", desc: "Equipment not working" },
];

// Per-region service response (derived display copy keyed to existing location slugs)
const SERVICE_COVERAGE = {
  nairobi: { engineers: "8 engineers", response: "Same-day", radius: "Nairobi metro + Central" },
  mombasa: { engineers: "3 engineers", response: "Within 24 hrs", radius: "Coast region" },
  kampala: { engineers: "4 engineers", response: "Within 24 hrs", radius: "Greater Kampala" },
  kigali:  { engineers: "3 engineers", response: "Within 48 hrs", radius: "Kigali + Northern" },
};

// ───────── Field helper (mirrors contact page) ─────────
const SvcField = ({ label, required, hint, children }) => (
  <label style={{ display: "block" }}>
    <span style={{ display: "flex", alignItems: "baseline", justifyContent: "space-between", marginBottom: 7 }}>
      <span style={{ fontSize: 13, fontWeight: 600, color: "var(--ink-2)" }}>
        {label}{required && <span style={{ color: "var(--accent)", marginLeft: 3 }}>*</span>}
      </span>
      {hint && <span style={{ fontSize: 11.5, color: "var(--ink-4)" }}>{hint}</span>}
    </span>
    {children}
  </label>
);

const ServicePage = ({ navigate, params }) => {
  const direction = document.documentElement.getAttribute("data-direction") || "editorial";
  const isWorkshop = direction === "workshop";
  const locations = window.SHEFFIELD_LOCATIONS;

  const [form, setForm] = React.useState({
    equipment: params.equipment || EQUIPMENT_TYPES[0],
    urgency: "soon",
    brand: "", serial: "",
    name: "", business: "", email: "", phone: "",
    location: "nairobi", message: "", consent: false,
  });
  const [sent, setSent] = React.useState(false);
  const [errors, setErrors] = React.useState({});
  const set = (k, v) => setForm(f => ({ ...f, [k]: v }));

  const submit = (e) => {
    e.preventDefault();
    const errs = {};
    if (!form.name.trim()) errs.name = true;
    if (!/.+@.+\..+/.test(form.email)) errs.email = true;
    if (!form.message.trim()) errs.message = true;
    if (!form.consent) errs.consent = true;
    setErrors(errs);
    if (Object.keys(errs).length === 0) {
      setSent(true);
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };

  const ref = "SVC-" + Math.floor(100000 + Math.random() * 900000);

  return (
    <div className="page-fade">

      {/* ───────── Masthead ───────── */}
      <section style={{ background: "var(--bg-sunken)", borderBottom: "1px solid var(--line)" }}>
        <div className="container" style={{ paddingTop: isWorkshop ? 44 : 64, paddingBottom: isWorkshop ? 44 : 64 }}>
          <div style={{ display: "grid", gridTemplateColumns: "1.25fr 0.9fr", gap: 48, alignItems: "stretch" }}>
            {/* Left: copy */}
            <div style={{ alignSelf: "center" }}>
              <div style={{ display: "flex", alignItems: "center", gap: 8, fontSize: 12.5, color: "var(--ink-3)", marginBottom: 14 }}>
                <a href="#" onClick={(e) => { e.preventDefault(); navigate("home"); }} style={{ color: "var(--ink-3)" }}>Home</a>
                <IconChevronR size={13} sw={1.6} style={{ color: "var(--ink-4)" }}/>
                <span style={{ color: "var(--ink-2)" }}>Service & support</span>
              </div>
              <span className="kicker">After-sales & uptime</span>
              <h1 style={{
                fontSize: isWorkshop ? 40 : 50, lineHeight: 1.04, marginTop: 12,
                letterSpacing: "-0.02em",
              }}>
                Keep your kitchen<br/>
                <span style={{ color: "var(--accent)", fontStyle: isWorkshop ? "normal" : "italic" }}>running</span>.
              </h1>
              <p style={{ marginTop: 18, fontSize: 16, lineHeight: 1.6, color: "var(--ink-2)", maxWidth: 520 }}>
                We don't disappear after delivery. Sheffield runs the largest field-service network in East Africa —
                engineers, genuine spares and maintenance plans that keep your equipment cooking, not waiting on parts.
              </p>
              <div style={{ marginTop: 26, display: "flex", gap: 28, flexWrap: "wrap" }}>
                {[
                  { icon: IconShield, k: "Standard SLA", v: "48-hour response" },
                  { icon: IconWrench, k: "Field engineers", v: "18 across 4 cities" },
                  { icon: IconCog, k: "Genuine spares", v: "Held in-country" },
                ].map((s, i) => (
                  <div key={i} style={{ display: "flex", gap: 11, alignItems: "center" }}>
                    <span style={{
                      width: 38, height: 38, borderRadius: isWorkshop ? 5 : 10, flexShrink: 0,
                      background: "var(--surface)", border: "1px solid var(--line)",
                      display: "flex", alignItems: "center", justifyContent: "center", color: "var(--secondary)",
                    }}>
                      <s.icon size={18} sw={1.6}/>
                    </span>
                    <div>
                      <div style={{ fontSize: 11.5, color: "var(--ink-3)" }}>{s.k}</div>
                      <div style={{ fontSize: 14, fontWeight: 600, color: "var(--ink)" }}>{s.v}</div>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            {/* Right: emergency / booking card */}
            <div style={{
              background: "var(--brand-blue-700)", color: "#f3eadd",
              borderRadius: "var(--radius-lg)", padding: 32,
              display: "flex", flexDirection: "column", justifyContent: "center",
              position: "relative", overflow: "hidden",
            }}>
              <div style={{
                position: "absolute", inset: 0,
                backgroundImage: "radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px)",
                backgroundSize: "16px 16px", pointerEvents: "none",
              }}/>
              <div style={{ position: "relative" }}>
                <div style={{
                  display: "inline-flex", alignItems: "center", gap: 7, marginBottom: 14,
                  padding: "5px 11px", borderRadius: 999, background: "rgba(184,115,51,0.22)",
                  fontSize: 11.5, fontWeight: 700, letterSpacing: "0.08em", textTransform: "uppercase", color: "var(--warm-1)",
                }}>
                  <span style={{ width: 7, height: 7, borderRadius: 999, background: "#33d17a", boxShadow: "0 0 0 3px rgba(51,209,122,0.25)" }}/>
                  24/7 emergency line
                </div>
                <div style={{ fontSize: 11.5, fontWeight: 700, letterSpacing: "0.12em", textTransform: "uppercase", color: "var(--warm-1)" }}>
                  Kitchen down? Call now
                </div>
                <a href="tel:+254202345612" style={{
                  display: "block", marginTop: 12, fontFamily: "var(--font-heading)",
                  fontSize: 32, color: "#fff", letterSpacing: "-0.01em",
                }}>
                  +254 20 234 5612
                </a>
                <div style={{ fontSize: 13, color: "#c9bea4", marginTop: 6 }}>Active contract holders — engineer on call, day or night.</div>

                <div style={{ height: 1, background: "rgba(255,255,255,0.14)", margin: "22px 0" }}/>

                <div style={{ display: "flex", flexDirection: "column", gap: 10 }}>
                  <a href="#book" onClick={(e) => { e.preventDefault(); document.getElementById("svc-book")?.scrollIntoView({ behavior: "smooth" }); }} className="btn" style={{
                    background: "var(--accent)", color: "var(--accent-ink)", fontWeight: 600, justifyContent: "center", width: "100%",
                  }}>
                    <IconWrench size={17} sw={1.7}/> Book an engineer
                  </a>
                  <a href="mailto:service@sheffield.co.ke" className="btn" style={{
                    background: "rgba(255,255,255,0.1)", color: "#f6ecd9",
                    border: "1px solid rgba(255,255,255,0.18)", justifyContent: "center", width: "100%",
                  }}>
                    <IconMail size={17} sw={1.6}/> service@sheffield.co.ke
                  </a>
                </div>

                <div style={{ marginTop: 18, display: "flex", alignItems: "center", gap: 8, fontSize: 12.5, color: "#d8c79d" }}>
                  <IconCertified size={15} sw={1.6} style={{ color: "var(--warm-1)" }}/>
                  Manufacturer-trained on Rational, Hobart &amp; Williams.
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ───────── Capabilities ───────── */}
      <section style={{ paddingTop: isWorkshop ? 48 : 72 }}>
        <div className="container">
          <div style={{ display: "flex", alignItems: "flex-end", justifyContent: "space-between", gap: 20, marginBottom: 24, flexWrap: "wrap" }}>
            <div>
              <span className="kicker">What we do</span>
              <h2 style={{ fontSize: isWorkshop ? 30 : 36, marginTop: 10 }}>Service that covers the whole kitchen</h2>
            </div>
            <p style={{ fontSize: 14, color: "var(--ink-3)", maxWidth: 380, lineHeight: 1.55 }}>
              From a single fryer to a full commercial line — one team for installation, maintenance, repair and compliance.
            </p>
          </div>

          <div style={{ display: "grid", gridTemplateColumns: "repeat(3, 1fr)", gap: isWorkshop ? 14 : 18 }}>
            {SERVICE_CAPABILITIES.map((c, i) => (
              <div key={i} style={{
                background: "var(--surface)", border: "1px solid var(--line)",
                borderRadius: "var(--radius-lg)", padding: 24, boxShadow: "var(--shadow-sm)",
              }}>
                <span style={{
                  width: 44, height: 44, borderRadius: isWorkshop ? 6 : 11,
                  background: "var(--tag-bg)", color: "var(--secondary)",
                  display: "flex", alignItems: "center", justifyContent: "center",
                }}>
                  <c.icon size={22} sw={1.6}/>
                </span>
                <div style={{ fontFamily: "var(--font-heading)", fontSize: 20, marginTop: 16 }}>{c.title}</div>
                <p style={{ fontSize: 13.5, color: "var(--ink-3)", lineHeight: 1.55, marginTop: 8 }}>{c.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ───────── Plans ───────── */}
      <section style={{ paddingTop: isWorkshop ? 56 : 88 }}>
        <div className="container">
          <div style={{ textAlign: "center", maxWidth: 620, margin: "0 auto 36px" }}>
            <span className="kicker">Maintenance plans</span>
            <h2 style={{ fontSize: isWorkshop ? 30 : 36, marginTop: 10 }}>Cover that pays for itself in uptime</h2>
            <p style={{ fontSize: 15, color: "var(--ink-3)", lineHeight: 1.6, marginTop: 12 }}>
              Pay per visit, or put your kitchen on a plan with priority response and parts discounts. Switch or scale anytime.
            </p>
          </div>

          <div style={{ display: "grid", gridTemplateColumns: "repeat(3, 1fr)", gap: isWorkshop ? 16 : 22, alignItems: "stretch" }}>
            {SERVICE_PLANS.map(plan => (
              <div key={plan.key} style={{
                position: "relative",
                background: plan.featured ? "var(--warm-3)" : "var(--surface)",
                color: plan.featured ? "#e6ddc8" : "var(--ink)",
                border: "1px solid " + (plan.featured ? "transparent" : "var(--line)"),
                borderRadius: "var(--radius-lg)", padding: 28,
                boxShadow: plan.featured ? "var(--shadow)" : "var(--shadow-sm)",
                display: "flex", flexDirection: "column",
              }}>
                {plan.featured && (
                  <span style={{
                    position: "absolute", top: -12, left: "50%", transform: "translateX(-50%)",
                    padding: "4px 13px", borderRadius: 999, background: "var(--accent)", color: "#fff",
                    fontSize: 11, fontWeight: 700, letterSpacing: "0.08em", textTransform: "uppercase",
                    whiteSpace: "nowrap",
                  }}>Most popular</span>
                )}
                <div style={{ fontFamily: "var(--font-heading)", fontSize: 24 }}>{plan.name}</div>
                <div style={{ fontSize: 13, color: plan.featured ? "#c9bea4" : "var(--ink-3)", marginTop: 4 }}>{plan.tagline}</div>

                <div style={{ marginTop: 20, paddingBottom: 20, borderBottom: "1px solid " + (plan.featured ? "rgba(230,221,200,0.16)" : "var(--line)") }}>
                  <div style={{ fontFamily: "var(--font-heading)", fontSize: 28, color: plan.featured ? "#fff" : "var(--ink)", letterSpacing: "-0.01em" }}>{plan.price}</div>
                  <div style={{ fontSize: 12.5, color: plan.featured ? "#c9bea4" : "var(--ink-4)", marginTop: 3 }}>{plan.priceNote}</div>
                </div>

                <ul style={{ listStyle: "none", padding: 0, margin: "20px 0 24px", display: "flex", flexDirection: "column", gap: 11, flex: 1 }}>
                  {plan.features.map((f, i) => (
                    <li key={i} style={{ display: "flex", gap: 10, alignItems: "flex-start", fontSize: 13.5, lineHeight: 1.45 }}>
                      <span style={{
                        marginTop: 1, flexShrink: 0,
                        color: plan.featured ? "var(--warm-1)" : "var(--secondary)",
                      }}>
                        <IconCheck size={16} sw={2.2}/>
                      </span>
                      <span style={{ color: plan.featured ? "#e6ddc8" : "var(--ink-2)" }}>{f}</span>
                    </li>
                  ))}
                </ul>

                <button
                  className={"btn " + (plan.featured ? "btn-primary" : "btn-outline")}
                  style={{ width: "100%", ...(plan.featured ? {} : {}) }}
                  onClick={() => {
                    if (plan.key === "careplus") navigate("contact", { inquiry: "Project consultation" });
                    else document.getElementById("svc-book")?.scrollIntoView({ behavior: "smooth" });
                  }}>
                  {plan.cta} <IconArrow size={15} sw={2}/>
                </button>
              </div>
            ))}
          </div>

          <p style={{ textAlign: "center", fontSize: 12.5, color: "var(--ink-4)", marginTop: 18 }}>
            Prices exclude VAT. Plan pricing scales with equipment count and location — we'll quote your exact fleet.
          </p>
        </div>
      </section>

      {/* ───────── Booking form + sidebar ───────── */}
      <section id="svc-book" style={{ paddingTop: isWorkshop ? 56 : 88, scrollMarginTop: 24 }}>
        <div className="container">
          <div style={{ display: "grid", gridTemplateColumns: "1.5fr 0.85fr", gap: 40, alignItems: "start" }}>

            {/* Form card */}
            <div style={{
              background: "var(--surface)", border: "1px solid var(--line)",
              borderRadius: "var(--radius-lg)", padding: 32, boxShadow: "var(--shadow-sm)",
            }}>
              {sent ? (
                <div style={{ padding: "20px 0", textAlign: "center" }}>
                  <div style={{
                    width: 64, height: 64, borderRadius: 999, margin: "0 auto 18px",
                    background: "hsl(145 50% 92%)", color: "hsl(150 60% 32%)",
                    display: "flex", alignItems: "center", justifyContent: "center",
                  }}>
                    <IconCheck size={30} sw={2}/>
                  </div>
                  <h2 style={{ fontSize: 26 }}>Service request logged</h2>
                  <p style={{ fontSize: 15, color: "var(--ink-2)", maxWidth: 460, margin: "12px auto 0", lineHeight: 1.6 }}>
                    Thanks, {form.name.split(" ")[0] || "there"}. A service coordinator will confirm your engineer slot
                    {form.urgency === "down"
                      ? <> — flagged <strong style={{ color: "var(--accent)" }}>kitchen down</strong>, so expect a call shortly.</>
                      : <> within <strong style={{ color: "var(--ink)" }}>2 working hours</strong>.</>}
                    {" "}We've emailed a copy to {form.email}.
                  </p>
                  <div style={{
                    display: "inline-flex", alignItems: "center", gap: 8, marginTop: 20,
                    padding: "8px 14px", background: "var(--bg-sunken)", borderRadius: 999,
                    fontSize: 13, color: "var(--ink-2)",
                  }}>
                    <span style={{ color: "var(--ink-3)" }}>Job reference</span>
                    <strong style={{ fontFamily: "var(--font-mono)", letterSpacing: "0.02em" }}>{ref}</strong>
                  </div>
                  <div style={{ marginTop: 24, display: "flex", gap: 10, justifyContent: "center" }}>
                    <button className="btn btn-primary" onClick={() => navigate("catalog")}>Browse equipment <IconArrow size={15} sw={2}/></button>
                    <button className="btn btn-outline" onClick={() => { setSent(false); setForm(f => ({ ...f, message: "", consent: false })); }}>Log another</button>
                  </div>
                </div>
              ) : (
                <form onSubmit={submit}>
                  <h2 style={{ fontSize: isWorkshop ? 24 : 28 }}>Book an engineer</h2>
                  <p style={{ fontSize: 14, color: "var(--ink-3)", marginTop: 6, marginBottom: 24 }}>
                    Tell us what's happening. The clearer the detail, the better-stocked the van that arrives.
                  </p>

                  {/* Urgency */}
                  <div style={{ marginBottom: 22 }}>
                    <span style={{ fontSize: 13, fontWeight: 600, color: "var(--ink-2)", display: "block", marginBottom: 10 }}>How urgent is it?</span>
                    <div style={{ display: "grid", gridTemplateColumns: "repeat(3, 1fr)", gap: 10 }}>
                      {URGENCY.map(u => {
                        const on = form.urgency === u.key;
                        const danger = u.key === "down";
                        return (
                          <button type="button" key={u.key} onClick={() => set("urgency", u.key)} style={{
                            textAlign: "left", padding: "12px 14px",
                            borderRadius: isWorkshop ? 4 : 10,
                            border: "1px solid " + (on ? (danger ? "var(--accent)" : "var(--secondary)") : "var(--line-strong)"),
                            background: on ? (danger ? "hsl(354 68% 96%)" : "var(--tag-bg)") : "var(--surface)",
                            transition: "all 120ms ease", cursor: "pointer",
                          }}>
                            <span style={{ display: "flex", alignItems: "center", gap: 7, fontSize: 13.5, fontWeight: 600, color: on && danger ? "var(--accent)" : "var(--ink)" }}>
                              {danger && <span style={{ width: 7, height: 7, borderRadius: 999, background: "var(--accent)", flexShrink: 0 }}/>}
                              {u.label}
                            </span>
                            <span style={{ display: "block", fontSize: 11.5, color: "var(--ink-3)", marginTop: 3 }}>{u.desc}</span>
                          </button>
                        );
                      })}
                    </div>
                  </div>

                  <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 18 }}>
                    <SvcField label="Equipment type" required>
                      <select className="select" value={form.equipment} onChange={e => set("equipment", e.target.value)}>
                        {EQUIPMENT_TYPES.map(t => <option key={t} value={t}>{t}</option>)}
                      </select>
                    </SvcField>
                    <SvcField label="Nearest branch">
                      <select className="select" value={form.location} onChange={e => set("location", e.target.value)}>
                        {locations.map(l => (
                          <option key={l.slug} value={l.slug}>{l.city}, {l.country}{l.isHQ ? " (HQ)" : ""}</option>
                        ))}
                      </select>
                    </SvcField>
                    <SvcField label="Brand / make" hint="Optional">
                      <input className="input" value={form.brand} onChange={e => set("brand", e.target.value)} placeholder="e.g. Rational, Hobart"/>
                    </SvcField>
                    <SvcField label="Model / serial" hint="Optional">
                      <input className="input" value={form.serial} onChange={e => set("serial", e.target.value)} placeholder="On the rating plate"/>
                    </SvcField>
                    <SvcField label="Contact name" required>
                      <input className="input" value={form.name} onChange={e => set("name", e.target.value)}
                        placeholder="Jane Mwangi"
                        style={errors.name ? { borderColor: "var(--accent)" } : null}/>
                    </SvcField>
                    <SvcField label="Business name" hint="Optional">
                      <input className="input" value={form.business} onChange={e => set("business", e.target.value)} placeholder="e.g. Artcaffé Group"/>
                    </SvcField>
                    <SvcField label="Email" required>
                      <input className="input" type="email" value={form.email} onChange={e => set("email", e.target.value)}
                        placeholder="jane@business.co.ke"
                        style={errors.email ? { borderColor: "var(--accent)" } : null}/>
                    </SvcField>
                    <SvcField label="Phone" hint="Optional">
                      <input className="input" value={form.phone} onChange={e => set("phone", e.target.value)} placeholder="+254 7…"/>
                    </SvcField>
                  </div>

                  <div style={{ marginTop: 18 }}>
                    <SvcField label="Describe the fault or job" required>
                      <textarea value={form.message} onChange={e => set("message", e.target.value)}
                        rows={4} placeholder="What's happening, when it started, any error codes — and the best time for an engineer to visit."
                        style={{
                          width: "100%", padding: "12px 14px", background: "var(--surface)",
                          border: "1px solid " + (errors.message ? "var(--accent)" : "var(--line)"),
                          borderRadius: "var(--radius)", color: "var(--ink)", fontSize: 14,
                          lineHeight: 1.55, resize: "vertical", outline: "none", fontFamily: "var(--font-body)",
                        }}/>
                    </SvcField>
                  </div>

                  <label style={{ display: "flex", gap: 11, alignItems: "flex-start", marginTop: 18, cursor: "pointer" }}>
                    <input type="checkbox" checked={form.consent} onChange={e => set("consent", e.target.checked)}
                      style={{ width: 18, height: 18, marginTop: 2, accentColor: "var(--accent)", flexShrink: 0 }}/>
                    <span style={{ fontSize: 13, color: errors.consent ? "var(--accent)" : "var(--ink-3)", lineHeight: 1.5 }}>
                      I agree to Sheffield contacting me about this service request and accept the{" "}
                      <a href="#" onClick={e => e.preventDefault()} style={{ color: "var(--secondary)", textDecoration: "underline" }}>privacy policy</a>.
                    </span>
                  </label>

                  <div style={{ marginTop: 24, display: "flex", alignItems: "center", gap: 14, flexWrap: "wrap" }}>
                    <button type="submit" className="btn btn-primary btn-lg">Request engineer <IconArrow size={16} sw={2}/></button>
                    <span style={{ fontSize: 12.5, color: "var(--ink-4)", display: "inline-flex", alignItems: "center", gap: 6 }}>
                      <IconShield size={14} sw={1.6}/> Coordinator confirms within 2 working hours
                    </span>
                  </div>
                </form>
              )}
            </div>

            {/* Sidebar */}
            <div style={{ display: "flex", flexDirection: "column", gap: 18 }}>
              <div style={{
                background: "var(--surface)", border: "1px solid var(--line)",
                borderRadius: "var(--radius-lg)", padding: 24, boxShadow: "var(--shadow-sm)",
              }}>
                <div style={{ fontSize: 11.5, fontWeight: 700, letterSpacing: "0.1em", textTransform: "uppercase", color: "var(--ink-3)" }}>
                  How a callout works
                </div>
                <div style={{ marginTop: 16, display: "flex", flexDirection: "column", gap: 16 }}>
                  {[
                    { t: "We triage & quote", d: "A coordinator confirms the fault, likely parts and the callout window." },
                    { t: "Engineer is dispatched", d: "Manufacturer-trained, with common spares already on the van." },
                    { t: "Fixed & documented", d: "Repair, safety check and a service report for your compliance log." },
                  ].map((s, i) => (
                    <div key={i} style={{ display: "flex", gap: 13 }}>
                      <span style={{
                        width: 26, height: 26, borderRadius: 999, flexShrink: 0,
                        background: "var(--tag-bg)", color: "var(--secondary)",
                        display: "flex", alignItems: "center", justifyContent: "center",
                        fontSize: 13, fontWeight: 700, fontFamily: "var(--font-heading)",
                      }}>{i + 1}</span>
                      <div>
                        <div style={{ fontSize: 14, fontWeight: 600, color: "var(--ink)" }}>{s.t}</div>
                        <div style={{ fontSize: 12.5, color: "var(--ink-3)", lineHeight: 1.5, marginTop: 2 }}>{s.d}</div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>

              <div style={{
                background: "var(--warm-3)", color: "#e6ddc8",
                borderRadius: "var(--radius-lg)", padding: 24,
              }}>
                <div style={{ fontSize: 11.5, fontWeight: 700, letterSpacing: "0.1em", textTransform: "uppercase", color: "#d8c79d" }}>
                  Service desk hours
                </div>
                <div style={{ marginTop: 14, display: "flex", flexDirection: "column", gap: 9, fontSize: 13.5 }}>
                  {[["Mon – Fri", "7:30 – 18:00"], ["Saturday", "8:00 – 14:00"], ["Emergency line", "24 / 7"]].map(([d, h], i) => (
                    <div key={i} style={{ display: "flex", justifyContent: "space-between", color: "#c9bea4" }}>
                      <span>{d}</span><span style={{ color: "#f3eadd", fontWeight: 500 }}>{h}</span>
                    </div>
                  ))}
                </div>
                <div style={{ height: 1, background: "rgba(230,221,200,0.16)", margin: "16px 0" }}/>
                <div style={{ fontSize: 12.5, color: "#c9bea4", lineHeight: 1.55 }}>
                  The 24/7 emergency line is reserved for Care and Care+ contract holders. All times EAT (GMT+3).
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      {/* ───────── Coverage ───────── */}
      <section style={{ paddingTop: isWorkshop ? 56 : 88 }}>
        <div className="container">
          <div style={{ display: "flex", alignItems: "flex-end", justifyContent: "space-between", gap: 20, marginBottom: 24, flexWrap: "wrap" }}>
            <div>
              <span className="kicker">On the ground</span>
              <h2 style={{ fontSize: isWorkshop ? 30 : 36, marginTop: 10 }}>Engineers near your kitchen</h2>
            </div>
            <p style={{ fontSize: 14, color: "var(--ink-3)", maxWidth: 380, lineHeight: 1.55 }}>
              Field teams based at every branch — so a breakdown is a short drive, not a flight and a customs wait.
            </p>
          </div>

          <div style={{ display: "grid", gridTemplateColumns: "repeat(4, 1fr)", gap: isWorkshop ? 14 : 18 }}>
            {locations.map(l => {
              const cov = SERVICE_COVERAGE[l.slug] || {};
              return (
                <div key={l.slug} style={{
                  background: "var(--surface)", border: "1px solid var(--line)",
                  borderRadius: "var(--radius-lg)", padding: 22, boxShadow: "var(--shadow-sm)",
                  display: "flex", flexDirection: "column",
                }}>
                  <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between" }}>
                    <span style={{ display: "inline-flex", alignItems: "center", gap: 7, fontFamily: "var(--font-heading)", fontSize: 20 }}>
                      <IconLocation size={17} sw={1.6} style={{ color: "var(--secondary)" }}/> {l.city}
                    </span>
                    {l.isHQ && <span className="badge badge-soft" style={{ fontSize: 10 }}>HQ</span>}
                  </div>
                  <div style={{ fontSize: 12.5, color: "var(--ink-4)", marginTop: 4 }}>{l.country}</div>

                  <div style={{ marginTop: 16, paddingTop: 16, borderTop: "1px solid var(--line)", display: "flex", flexDirection: "column", gap: 11 }}>
                    <div>
                      <div style={{ fontSize: 11, color: "var(--ink-4)", textTransform: "uppercase", letterSpacing: "0.06em" }}>Response</div>
                      <div style={{ fontSize: 14.5, fontWeight: 600, color: "var(--secondary)", marginTop: 2 }}>{cov.response}</div>
                    </div>
                    <div style={{ display: "flex", gap: 18 }}>
                      <div>
                        <div style={{ fontSize: 11, color: "var(--ink-4)", textTransform: "uppercase", letterSpacing: "0.06em" }}>Team</div>
                        <div style={{ fontSize: 13.5, fontWeight: 600, color: "var(--ink)", marginTop: 2 }}>{cov.engineers}</div>
                      </div>
                    </div>
                    <div>
                      <div style={{ fontSize: 11, color: "var(--ink-4)", textTransform: "uppercase", letterSpacing: "0.06em" }}>Covers</div>
                      <div style={{ fontSize: 13, color: "var(--ink-2)", marginTop: 2 }}>{cov.radius}</div>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>

          <div style={{ marginTop: 22, display: "flex", justifyContent: "center", gap: 12, flexWrap: "wrap" }}>
            <button className="btn btn-outline" onClick={() => navigate("contact")}>Find a showroom <IconArrow size={15} sw={2}/></button>
            <button className="btn btn-primary" onClick={() => document.getElementById("svc-book")?.scrollIntoView({ behavior: "smooth" })}>Book an engineer <IconWrench size={15} sw={1.8}/></button>
          </div>
        </div>
      </section>

    </div>
  );
};

Object.assign(window, { ServicePage });
