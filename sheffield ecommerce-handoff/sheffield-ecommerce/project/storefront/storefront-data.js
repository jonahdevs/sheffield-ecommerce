// Sheffield storefront — real catalog data extracted from new-ecommerce/database/data/*.json

window.SF = {
  // Hero rotator slides (real banner assets)
  hero: [
    { src: 'assets/banners/topline.webp',         alt: 'Add to your topline',            cta: 'Upgrade now',            align: 'right' },
    { src: 'assets/banners/coffee-machines.webp',  alt: 'Premium coffee machines',        cta: 'Shop coffee machines',   align: 'right' },
    { src: 'assets/banners/refrigeration.webp',    alt: 'Smart cooling',                  cta: 'Shop refrigeration',     align: 'right' },
    { src: 'assets/banners/bakery-prep.webp',      alt: 'Bakery preparation equipment',   cta: 'Shop bakery prep',       align: 'center' },
    { src: 'assets/banners/clearance-sale.webp',   alt: 'Limited time clearance sale',    cta: 'Shop clearance',         align: 'left' },
  ],

  usps: [
    { icon: 'building', title: 'Africa No. 1',  sub: 'In Commercial Equipment' },
    { icon: 'check',    title: 'Guaranteed',    sub: 'Quality Assurance' },
    { icon: 'expand',   title: 'Customized',    sub: 'Bespoke Solutions' },
    { icon: 'truck',    title: 'Fast Delivery', sub: 'Countrywide Shipping' },
    { icon: 'code',     title: 'Installation',  sub: 'Professional Setup' },
  ],

  // Categories — names from categories.json (homepage_featured + navbar set). glyph picks a tile icon.
  categories: [
    { name: 'Vegetable Processors', count: 42, glyph: 'blade',  desc: 'Commercial cutting, slicing, dicing and shredding machines for high-volume kitchens.' },
    { name: 'Meat Processors',      count: 38, glyph: 'blade',  desc: 'Mincers, slicers, bandsaws and tenderisers for butcheries, delis and commercial kitchens.' },
    { name: 'Meat Displays',        count: 16, glyph: 'fridge', desc: 'Refrigerated meat counters that hold fresh and cured product at temperature with full visibility.' },
    { name: 'Juice Processors',     count: 15, glyph: 'cup',    desc: 'Extractors, squeezers and dispensers for restaurants, juice bars and catering.' },
    { name: 'Refrigeration',        count: 64, glyph: 'fridge', desc: 'Upright fridges, undercounter chillers, freezers and walk-in cold rooms for reliable preservation.' },
    { name: 'Cold Displays',        count: 29, glyph: 'fridge', desc: 'Open and closed chilled display units for beverages, dairy, salads and deli items.' },
    { name: 'Pastry Displays',      count: 18, glyph: 'cake',   desc: 'Elegant cases that present pastries, cakes and baked goods hygienically.' },
    { name: 'Ice Cream Displays',   count: 12, glyph: 'cup',    desc: 'Freezer display units for gelato, sorbet and ice cream with precise low temperatures.' },
    { name: 'Ovens',                count: 47, glyph: 'oven',   desc: 'Combi, convection and deck ovens engineered for consistent, high-output cooking.' },
    { name: 'Bakery Preparation',   count: 33, glyph: 'cake',   desc: 'Mixers, provers, sheeters and dough equipment for bakeries and patisseries.' },
    { name: 'Induction Cookers',    count: 21, glyph: 'flame',  desc: 'Energy-efficient induction ranges and woks for fast, controllable heat.' },
    { name: 'Fryers',               count: 26, glyph: 'flame',  desc: 'Gas and electric fryers built for consistent results and heavy daily service.' },
    { name: 'Coffee Machines',      count: 19, glyph: 'cup',    desc: 'Traditional espresso, bean-to-cup machines and grinders from leading roasters.' },
    { name: 'Dishwashers',          count: 23, glyph: 'fridge', desc: 'Undercounter, hood-type and conveyor warewashing for any volume of covers.' },
  ],

  // Brand names from brands.json (logos live in storage, so we render the serif text fallback the card uses)
  brands: ['RATIONAL','RANCILIO','COMENDA','SKYMSEN','TECNODOM','DR. COFFEE','SAMMIC','SANTOS','BLUELINE','HK-REDLINE','EMPERO','ASTAR','WINTERHALTER','ELECTROLUX'],

  // New arrivals — real published products (name/brand/sku/price from products.json)
  arrivals: [
    { name: 'Vegetable Processor PA7',                 brand: 'SKYMSEN',    sku: 'IMG/FPR/00042', price: 202900 },
    { name: 'Potato Peeler 20 KG',                     brand: 'EMPERO',     sku: 'IMG/FPR/00008', price: 285615 },
    { name: 'Potato Peeler With Door, Stainless 10KG', brand: 'SKYMSEN',    sku: 'IMG/FPR/00246', price: 204250 },
    { name: 'Meat Slicer Ø 300MM',                     brand: 'HK-REDLINE', sku: 'IMG/FPR/00046', price: 253750, sale: 228375 },
    { name: 'Meat Slicer Ø 250MM',                     brand: 'HK-REDLINE', sku: 'IMG/FPR/00179', price: 163750 },
    { name: 'Meat Grinder 22 Model TK-22',             brand: 'ASTAR',      sku: 'IMG/FPR/00164', price: 184000 },
    { name: 'Manual Vegetable Slicer JSCV-2200',       brand: 'SYSTEMATIC', sku: 'IMG/FPR/00051', price: 47900 },
    { name: 'Combi Oven iCombi Pro 6-1/1',             brand: 'RATIONAL',   sku: 'IMG/OVN/00112', price: null, quote: true },
    { name: 'Espresso Machine Classe 5',               brand: 'RANCILIO',   sku: 'IMG/COF/00033', price: 612000 },
    { name: 'Undercounter Dishwasher LF322',           brand: 'COMENDA',    sku: 'IMG/DWS/00074', price: 398500 },
  ],

  // Featured equipment
  featured: [
    { name: 'Combi Oven iCombi Pro 6-1/1',       brand: 'RATIONAL',   sku: 'IMG/OVN/00112', price: null, quote: true },
    { name: 'Espresso Machine Classe 5',         brand: 'RANCILIO',   sku: 'IMG/COF/00033', price: 612000 },
    { name: 'Blast Chiller 5 Trays',             brand: 'TECNODOM',   sku: 'IMG/REF/00210', price: 489000, sale: 439000 },
    { name: 'Pastry Display 1500mm',             brand: 'TECNODOM',   sku: 'IMG/CDS/00088', price: 356400 },
    { name: 'Citrus Juicer Pro',                 brand: 'SANTOS',     sku: 'IMG/JUI/00019', price: 128900 },
    { name: 'Hood-Type Dishwasher AC1',          brand: 'COMENDA',    sku: 'IMG/DWS/00091', price: null, quote: true },
  ],

  // Full catalog pool for the Shop & Category grids.
  // cat = category name · stock = ships now · rating = avg approved review (0 = none)
  catalog: [
    { name: 'Vegetable Processor PA7',                 brand: 'SKYMSEN',    sku: 'IMG/FPR/00042', cat: 'Vegetable Processors', price: 202900, stock: true,  rating: 5 },
    { name: 'Manual Vegetable Slicer JSCV-2200',       brand: 'SYSTEMATIC', sku: 'IMG/FPR/00051', cat: 'Vegetable Processors', price: 47900,  stock: true,  rating: 4 },
    { name: 'Vegetable Cutter Combo 6-Disc',           brand: 'SKYMSEN',    sku: 'IMG/FPR/00067', cat: 'Vegetable Processors', price: 188400, stock: false, rating: 0 },
    { name: 'Potato Peeler 20 KG',                     brand: 'EMPERO',     sku: 'IMG/FPR/00008', cat: 'Potato Processors',    price: 285615, stock: true,  rating: 5 },
    { name: 'Potato Peeler With Door 10 KG',           brand: 'SKYMSEN',    sku: 'IMG/FPR/00246', cat: 'Potato Processors',    price: 204250, stock: true,  rating: 4 },
    { name: 'Potato Chipper On Stand',                 brand: 'SYSTEMATIC', sku: 'IMG/FPR/00088', cat: 'Potato Processors',    price: 62400,  stock: true,  rating: 0 },
    { name: 'Meat Slicer Ø 300MM',                     brand: 'HK-REDLINE', sku: 'IMG/FPR/00046', cat: 'Meat Processors',      price: 253750, sale: 228375, stock: true, rating: 5 },
    { name: 'Meat Slicer Ø 250MM',                     brand: 'HK-REDLINE', sku: 'IMG/FPR/00179', cat: 'Meat Processors',      price: 163750, stock: true,  rating: 4 },
    { name: 'Meat Grinder 22 Model TK-22',             brand: 'ASTAR',      sku: 'IMG/FPR/00164', cat: 'Meat Processors',      price: 184000, stock: false, rating: 3 },
    { name: 'Bandsaw Butchery BS-310',                 brand: 'HK-REDLINE', sku: 'IMG/FPR/00201', cat: 'Meat Processors',      price: 312000, stock: true,  rating: 0 },
    { name: 'Combi Oven iCombi Pro 6-1/1',             brand: 'RATIONAL',   sku: 'IMG/OVN/00112', cat: 'Ovens',                price: null,   quote: true,  stock: true, rating: 5 },
    { name: 'Combi Oven iCombi Pro 10-1/1',            brand: 'RATIONAL',   sku: 'IMG/OVN/00118', cat: 'Ovens',                price: null,   quote: true,  stock: true, rating: 5 },
    { name: 'Convection Oven 4-Tray',                  brand: 'TECNODOM',   sku: 'IMG/OVN/00074', cat: 'Ovens',                price: 198000, stock: true,  rating: 4 },
    { name: 'Deck Pizza Oven Twin',                    brand: 'HK-REDLINE', sku: 'IMG/OVN/00090', cat: 'Ovens',                price: 274500, sale: 247000, stock: true, rating: 4 },
    { name: 'Espresso Machine Classe 5',               brand: 'RANCILIO',   sku: 'IMG/COF/00033', cat: 'Coffee Machines',      price: 612000, stock: true,  rating: 5 },
    { name: 'Bean-to-Cup C11',                         brand: 'DR. COFFEE', sku: 'IMG/COF/00041', cat: 'Coffee Machines',      price: 389000, stock: false, rating: 4 },
    { name: 'Coffee Grinder On-Demand',                brand: 'RANCILIO',   sku: 'IMG/COF/00052', cat: 'Coffee Machines',      price: 96500,  stock: true,  rating: 0 },
    { name: 'Blast Chiller 5 Trays',                   brand: 'TECNODOM',   sku: 'IMG/REF/00210', cat: 'Refrigeration',        price: 489000, sale: 439000, stock: true, rating: 5 },
    { name: 'Upright Freezer 600L',                    brand: 'BLUELINE',   sku: 'IMG/REF/00133', cat: 'Refrigeration',        price: 218000, stock: true,  rating: 4 },
    { name: 'Undercounter Chiller 2-Door',             brand: 'BLUELINE',   sku: 'IMG/REF/00148', cat: 'Refrigeration',        price: 164900, stock: true,  rating: 0 },
    { name: 'Pastry Display 1500mm',                   brand: 'TECNODOM',   sku: 'IMG/CDS/00088', cat: 'Pastry Displays',      price: 356400, stock: true,  rating: 4 },
    { name: 'Curved-Glass Cake Display',               brand: 'TECNODOM',   sku: 'IMG/CDS/00094', cat: 'Pastry Displays',      price: 412000, stock: false, rating: 5 },
    { name: 'Citrus Juicer Pro',                       brand: 'SANTOS',     sku: 'IMG/JUI/00019', cat: 'Juice Processors',     price: 128900, stock: true,  rating: 4 },
    { name: 'Cold-Press Juicer #28',                   brand: 'SANTOS',     sku: 'IMG/JUI/00024', cat: 'Juice Processors',     price: 176500, stock: true,  rating: 0 },
    { name: 'Undercounter Dishwasher LF322',           brand: 'COMENDA',    sku: 'IMG/DWS/00074', cat: 'Dishwashers',          price: 398500, stock: true,  rating: 5 },
    { name: 'Hood-Type Dishwasher AC1',                brand: 'COMENDA',    sku: 'IMG/DWS/00091', cat: 'Dishwashers',          price: null,   quote: true,  stock: true, rating: 4 },
    { name: 'Induction Cooker Twin 7kW',               brand: 'HK-REDLINE', sku: 'IMG/IND/00012', cat: 'Induction Cookers',    price: 142000, stock: true,  rating: 4 },
    { name: 'Gas Fryer Twin-Tank 16L',                 brand: 'HK-REDLINE', sku: 'IMG/FRY/00029', cat: 'Fryers',               price: 88500,  sale: 79900, stock: true, rating: 3 },
  ],
};
