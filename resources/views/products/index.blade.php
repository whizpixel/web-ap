<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.75rem;color:var(--white);letter-spacing:-0.03em;">
                Nos <span style="color:var(--red-vivid);">Produits</span>
            </h2>
        </div>
    </x-slot>

    <style>
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.25rem;
        }

        .product-card {
            background: rgba(22,26,29,0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(229,56,59,0.12);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .product-card:hover {
            border-color: rgba(229,56,59,0.35);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.4);
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 100px; height: 100px;
            background: radial-gradient(circle, rgba(229,56,59,0.1) 0%, transparent 70%);
            border-radius: 50%;
            transition: all 0.3s;
        }

        .product-card:hover::before {
            transform: scale(1.5);
            opacity: 0.8;
        }

        .product-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--white);
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        .product-desc {
            font-size: 0.85rem;
            color: var(--gray-warm);
            line-height: 1.5;
            margin-bottom: 1.25rem;
            min-height: 2.5rem;
        }

        .product-price {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--red-vivid);
            letter-spacing: -0.03em;
        }

        .product-price span {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--gray-warm);
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(229,56,59,0.1);
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .section-title::before {
            content: '';
            display: block;
            width: 3px;
            height: 18px;
            background: var(--red-vivid);
            border-radius: 2px;
        }

        .count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(229,56,59,0.15);
            border: 1px solid rgba(229,56,59,0.25);
            color: var(--red-vivid);
            font-family: 'Syne', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.15rem 0.6rem;
            border-radius: 20px;
        }
    </style>

    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
        <div class="section-title" style="margin-bottom:0;">Catalogue</div>
        <span class="count-badge">{{ $products->count() }} produits</span>
    </div>

    @if($products->isEmpty())
        <div class="glass-card">
            <div class="empty-state">Aucun produit disponible pour le moment.</div>
        </div>
    @else
        <div class="products-grid">
            @foreach($products as $p)
                <div class="product-card">
                    <div class="product-name">{{ $p->name }}</div>
                    <div class="product-desc">{{ $p->description ?? '—' }}</div>
                    <div class="product-footer">
                        <div class="product-price">
                            {{ number_format($p->price, 2, ',', ' ') }}<span> €</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-app-layout>