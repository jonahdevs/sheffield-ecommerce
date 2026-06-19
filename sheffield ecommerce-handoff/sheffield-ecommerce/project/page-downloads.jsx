// Sheffield — Downloads / Spec sheets library. Direction-aware (editorial / workshop).
// Searchable, filterable index of every product's documents (spec sheet, install manual, service guide).
// Reuses SHEFFIELD_DATA (products, categories, brands), ProductIllustration, shared tokens & classes.

const DOC_TYPES = [
  { key: "spec",    label: "Spec sheet",    short: "Spec sheet",    icon: IconDocument, pages: "2 pp" },
  { key: "install", label: "Installation manual",        short: "Install manual", icon: IconWrench,   pages: "PDF" },
  { key: "service", label: "Service & maintenance guide", short: "Service guide",  icon: IconShield,   pages: "PDF" },
];

// Deterministic, sensible file sizes per product+doc so the list feels real and stable.
const docSize = (product, key) => {
  const seed = (product.slug.length * 7 + key.length * 13) % 5;
  if (key === "spec")    return ["320 KB", "0.4 MB", "0.5 MB", "0.6 MB", "0.8 MB"][seed];
  if (key === "install") return ["2.1 MB", "3.4 MB", "4.2 MB", "5.6 MB", "6.8 MB"][seed];
  return ["1.8 MB", "2.4 MB", "3.1 MB", "3.9 MB", "4.6 MB"][seed]; // service
};

// Which docs a product carries. Everything has a spec sheet; powered equipment also has manuals.
const docsFor = (product) => {
  const hasManuals = !!product.power && product.kind !== "knife";
  return DOC_TYPES.filter(d => d.key === "spec" || hasManuals);
};

const DownloadsPage = ({ navigate, params }) => {
  const direction = document.documentElement.getAttribute("data-direction") || "editorial";
  const isWorkshop = direction === "workshop";
  const D = window.SHEFFIELD_DATA;
  const products = D.products;
  const categories = D.categories;
  const brandsBySlug = React.useMemo(() => Object.fromEntries(D.brands.map(b => [b.slug, b])), [D.brands]);

  const [query, setQuery] = React.useState("");
  const [cat, setCat] = React.useState(params.category || "all");
  const [docType, setDocType] = React.useState("all");

  // Only categories that actually have products in this dataset
  const liveCats = React.useMemo(() => {
    const present = new Set(products.map(p => p.category));
    return categories.filter(c => present.has(c.slug));
  }, [products, categories]);

  const results = React.useMemo(() => {
    const q = query.trim().toLowerCase();
    return products.filter(p => {
      if (cat !== "all" && p.category !== cat) return false;
      if (docType !== "all" && !docsFor(p).some(d => d.key === docType)) return false;
      if (!q) return true;
      const brand = brandsBySlug[p.brand]?.name || "";
      return (p.name + " " + brand + " " + (p.sku || "")).toLowerCase().includes(q);
    });
  }, [products, query, cat, docType, brandsBySlug]);

  const totalDocs = React.useMemo(
    () => products.reduce((n, p) => n + docsFor(p).length, 0), [products]);

  const catName = (slug) => categories.find(c => c.slug === slug)?.name || slug;

  return (
    <div className="page-fade">

      {/* ───────── Masthead ───────── */}
      <section style={{ background: "var(--bg-sunken)", borderBottom: "1px solid var(--line)" }}>
        <div className="container" style={{ paddingTop: isWorkshop ? 40 : 56, paddingBottom: isWorkshop ? 40 : 56 }}>
          <div style={{ display: "flex", alignItems: "center", gap: 8, fontSize: 12.5, color: "var(--ink-3)", marginBottom: 14 }}>
            <a href="#" onClick={(e) => { e.preventDefault(); navigate("home"); }} style={{ color: "var(--ink-3)" }}>Home</a>
            <IconChevronR size={13} sw={1.6} style={{ color: "var(--ink-4)" }}/>
            <span style={{ color: "var(--ink-2)" }}>Spec sheets & manuals</span>
          </div>
          <div style={{ display: "grid", gridTemplateColumns: "1.4fr 0.9fr", gap: 48, alignItems: "end" }}>
            <div>
              <span className="kicker">Resource centre</span>
              <h1 style={{ fontSize: isWorkshop ? 38 : 46, lineHeight: 1.05, marginTop: 12, letterSpacing: "-0.02em" }}>
                Spec sheets &amp; <span style={{ color: "var(--accent)", fontStyle: isWorkshop ? "normal" : "italic" }}>manuals</span>
              </h1>
              <p style={{ marginTop: 16, fontSize: 16, lineHeight: 1.6, color: "var(--ink-2)", maxWidth: 540 }}>
                Technical drawings, connected loads, installation manuals and service guides for every line we carry —
                everything your consultant, installer or engineer needs, in one place.
              </p>
            </div>
            <div style={{ display: "flex", gap: 28, justifyContent: "flex-end", flexWrap: "wrap" }}>
              {[
                { v: products.length, k: "Products" },
                { v: totalDocs, k: "Documents" },
                { v: liveCats.length, k: "Categories" },
              ].map((s, i) => (
                <div key={i} style={{ textAlign: "right" }}>
                  <div style={{ fontFamily: "var(--font-heading)", fontSize: 34, color: "var(--ink)", lineHeight: 1 }}>{s.v}</div>
                  <div style={{ fontSize: 12, color: "var(--ink-3)", marginTop: 5, textTransform: "uppercase", letterSpacing: "0.06em" }}>{s.k}</div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* ───────── Toolbar ───────── */}
      <section style={{ position: "sticky", top: 0, zIndex: 20, background: "var(--bg)", borderBottom: "1px solid var(--line)" }}>
        <div className="container" style={{ paddingTop: 16, paddingBottom: 16 }}>
          <div style={{ display: "flex", gap: 14, alignItems: "center", flexWrap: "wrap" }}>
            {/* Search */}
            <div style={{ position: "relative", flex: "1 1 280px", minWidth: 240 }}>
              <span style={{ position: "absolute", left: 13, top: "50%", transform: "translateY(-50%)", color: "var(--ink-4)" }}>
                <IconSearch size={17} sw={1.7}/>
              </span>
              <input className="input" value={query} onChange={e => setQuery(e.target.value)}
                placeholder="Search by product, brand or SKU…"
                style={{ paddingLeft: 40 }}/>
              {query && (
                <button onClick={() => setQuery("")} aria-label="Clear"
                  style={{ position: "absolute", right: 10, top: "50%", transform: "translateY(-50%)", background: "transparent", border: 0, color: "var(--ink-4)", cursor: "pointer", padding: 4 }}>
                  <IconClose size={15} sw={1.8}/>
                </button>
              )}
            </div>

            {/* Category */}
            <select className="select" value={cat} onChange={e => setCat(e.target.value)} style={{ flex: "0 0 auto", width: "auto", minWidth: 180 }}>
              <option value="all">All categories</option>
              {liveCats.map(c => <option key={c.slug} value={c.slug}>{c.name}</option>)}
            </select>

            {/* Doc type chips */}
            <div style={{ display: "flex", gap: 7, flexWrap: "wrap" }}>
              {[{ key: "all", label: "All docs" }, ...DOC_TYPES.map(d => ({ key: d.key, label: d.short }))].map(t => {
                const on = docType === t.key;
                return (
                  <button key={t.key} onClick={() => setDocType(t.key)} style={{
                    height: 38, padding: "0 14px", fontSize: 13, fontWeight: 500,
                    borderRadius: isWorkshop ? 4 : 999,
                    border: "1px solid " + (on ? "var(--accent)" : "var(--line-strong)"),
                    background: on ? "var(--accent)" : "var(--surface)",
                    color: on ? "var(--accent-ink)" : "var(--ink-2)",
                    cursor: "pointer", transition: "all 120ms ease", whiteSpace: "nowrap",
                  }}>{t.label}</button>
                );
              })}
            </div>
          </div>
        </div>
      </section>

      {/* ───────── Results ───────── */}
      <section style={{ paddingTop: 28, paddingBottom: isWorkshop ? 56 : 88 }}>
        <div className="container">
          <div style={{ display: "flex", alignItems: "baseline", justifyContent: "space-between", marginBottom: 18, flexWrap: "wrap", gap: 8 }}>
            <div style={{ fontSize: 13.5, color: "var(--ink-3)" }}>
              <strong style={{ color: "var(--ink)" }}>{results.length}</strong> {results.length === 1 ? "product" : "products"}
              {cat !== "all" && <> in <strong style={{ color: "var(--ink)" }}>{catName(cat)}</strong></>}
              {docType !== "all" && <> with a <strong style={{ color: "var(--ink)" }}>{DOC_TYPES.find(d => d.key === docType)?.short.toLowerCase()}</strong></>}
            </div>
            {(query || cat !== "all" || docType !== "all") && (
              <button onClick={() => { setQuery(""); setCat("all"); setDocType("all"); }} style={{
                background: "transparent", border: 0, color: "var(--secondary)", fontSize: 13, cursor: "pointer", fontWeight: 500,
              }}>Clear filters</button>
            )}
          </div>

          {results.length === 0 ? (
            <div style={{
              border: "1px dashed var(--line-strong)", borderRadius: "var(--radius-lg)",
              padding: "56px 24px", textAlign: "center",
            }}>
              <span style={{ color: "var(--ink-4)" }}><IconSearch size={28} sw={1.4}/></span>
              <div style={{ fontFamily: "var(--font-heading)", fontSize: 22, marginTop: 12 }}>No documents match that</div>
              <p style={{ fontSize: 14, color: "var(--ink-3)", marginTop: 6 }}>Try a different search term, or clear the filters.</p>
              <button className="btn btn-outline" style={{ marginTop: 18 }}
                onClick={() => { setQuery(""); setCat("all"); setDocType("all"); }}>Reset filters</button>
            </div>
          ) : (
            <div style={{ display: "flex", flexDirection: "column", gap: isWorkshop ? 10 : 12 }}>
              {results.map(p => {
                const brand = brandsBySlug[p.brand];
                const docs = docsFor(p).filter(d => docType === "all" || d.key === docType);
                return (
                  <div key={p.slug} style={{
                    background: "var(--surface)", border: "1px solid var(--line)",
                    borderRadius: "var(--radius-lg)", padding: isWorkshop ? 16 : 18,
                    boxShadow: "var(--shadow-sm)",
                    display: "grid", gridTemplateColumns: "auto 1fr auto", gap: 18, alignItems: "center",
                  }}>
                    {/* Thumb */}
                    <button onClick={() => navigate("product", { slug: p.slug })} style={{
                      width: 68, height: 68, background: "var(--bg-sunken)", borderRadius: "var(--radius)",
                      padding: 8, border: "1px solid var(--line)", cursor: "pointer", flexShrink: 0,
                    }} aria-label={p.name}>
                      <ProductIllustration kind={p.kind} photo={p.photos?.[0]}/>
                    </button>

                    {/* Meta */}
                    <div style={{ minWidth: 0 }}>
                      <div style={{ display: "flex", alignItems: "center", gap: 8, flexWrap: "wrap" }}>
                        {brand && <span style={{ fontSize: 11.5, fontWeight: 700, letterSpacing: "0.06em", textTransform: "uppercase", color: "var(--secondary)" }}>{brand.name}</span>}
                        <span className="chip" style={{ height: 22, fontSize: 11 }}>{catName(p.category)}</span>
                      </div>
                      <a href="#" onClick={(e) => { e.preventDefault(); navigate("product", { slug: p.slug }); }}
                        style={{ display: "block", fontFamily: "var(--font-heading)", fontSize: isWorkshop ? 17 : 19, color: "var(--ink)", marginTop: 5, lineHeight: 1.25 }}>
                        {p.name}
                      </a>
                      <div style={{ display: "flex", gap: 16, marginTop: 6, fontSize: 12, color: "var(--ink-4)", flexWrap: "wrap" }}>
                        {p.sku && <span style={{ fontFamily: "var(--font-mono)" }}>{p.sku}</span>}
                        {p.dimensions && <span>{p.dimensions}</span>}
                        {p.power && <span>{p.power}</span>}
                      </div>
                    </div>

                    {/* Document download buttons */}
                    <div style={{ display: "flex", flexDirection: "column", gap: 7, alignItems: "stretch", minWidth: 210 }}>
                      {docs.map(d => (
                        <a key={d.key} href="#" onClick={(e) => e.preventDefault()} style={{
                          display: "flex", alignItems: "center", gap: 10,
                          padding: "8px 12px", borderRadius: "var(--radius)",
                          border: "1px solid var(--line)", background: "var(--bg)",
                          transition: "border-color 120ms ease, background 120ms ease",
                        }}
                          onMouseEnter={e => { e.currentTarget.style.borderColor = "var(--line-strong)"; e.currentTarget.style.background = "var(--bg-sunken)"; }}
                          onMouseLeave={e => { e.currentTarget.style.borderColor = "var(--line)"; e.currentTarget.style.background = "var(--bg)"; }}>
                          <span style={{ color: "var(--secondary)", flexShrink: 0 }}><d.icon size={17} sw={1.6}/></span>
                          <span style={{ minWidth: 0, flex: 1 }}>
                            <span style={{ display: "block", fontSize: 12.5, fontWeight: 600, color: "var(--ink)", lineHeight: 1.2 }}>{d.short}</span>
                            <span style={{ display: "block", fontSize: 11, color: "var(--ink-4)", marginTop: 1 }}>{d.pages} · {docSize(p, d.key)}</span>
                          </span>
                          <span style={{ color: "var(--ink-3)", flexShrink: 0 }}><IconDownload size={15} sw={1.7}/></span>
                        </a>
                      ))}
                    </div>
                  </div>
                );
              })}
            </div>
          )}

          {/* Footer help band */}
          <div style={{
            marginTop: isWorkshop ? 40 : 56,
            background: "var(--warm-3)", color: "#e6ddc8",
            borderRadius: "var(--radius-lg)", padding: isWorkshop ? 28 : 36,
            display: "grid", gridTemplateColumns: "1fr auto", gap: 24, alignItems: "center",
          }}>
            <div>
              <div style={{ fontFamily: "var(--font-heading)", fontSize: isWorkshop ? 22 : 26, color: "#fff" }}>Can't find a document?</div>
              <p style={{ fontSize: 14, color: "#c9bea4", marginTop: 8, lineHeight: 1.6, maxWidth: 560 }}>
                We hold full technical packs for discontinued and special-order equipment too. Tell us the model and
                we'll send the spec sheet, wiring diagram or service bulletin you need.
              </p>
            </div>
            <div style={{ display: "flex", gap: 10, flexWrap: "wrap", justifyContent: "flex-end" }}>
              <button className="btn" style={{ background: "var(--accent)", color: "#fff" }}
                onClick={() => navigate("contact", { inquiry: "Service & spares" })}>Request a document</button>
              <button className="btn" style={{ background: "rgba(255,255,255,0.1)", color: "#f6ecd9", border: "1px solid rgba(255,255,255,0.18)" }}
                onClick={() => navigate("service")}>Book an engineer</button>
            </div>
          </div>
        </div>
      </section>

    </div>
  );
};

Object.assign(window, { DownloadsPage });
