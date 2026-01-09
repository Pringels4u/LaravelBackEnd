<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color:#f8fafc;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div style="display:flex;gap:24px;align-items:flex-start;">
                <div style="flex:1;">
                    <div style="background:#fff;padding:20px;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,0.08);">
                        <h3 style="margin:0 0 8px;color:#111;font-size:1.25rem;font-weight:600;">Welkom bij Chiro Lembeek</h3>
                        <p style="margin:0 0 12px;color:#374151;">Blijf op de hoogte van recente nieuwsitems en aankomende activiteiten. Gebruik het menu om te navigeren of klik hieronder voor snelle acties.</p>

                        <div style="display:flex;gap:8px;margin-top:12px;">
                            <a href="{{ route('news.index') }}" style="background:#f97316;color:#fff;padding:8px 12px;border-radius:6px;text-decoration:none;">Bekijk nieuws</a>
                            <a href="{{ route('faq.index') }}" style="background:#efefef;color:#111;padding:8px 12px;border-radius:6px;text-decoration:none;">Bekijk FAQ</a>
                            <a href="{{ route('contact.create') }}" style="background:#e5e7eb;color:#111;padding:8px 12px;border-radius:6px;text-decoration:none;">Contact opnemen</a>
                        </div>
                    </div>

                    <div style="margin-top:16px;background:#fff;padding:16px;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
                        <h4 style="margin:0 0 12px;color:#111;font-size:1.125rem;font-weight:600;">Aankomende activiteiten</h4>
                        <ul style="margin:0;padding-left:18px;color:#374151;">
                            <li>Zaterdagspelen - elke zaterdag 14:00</li>
                            <li>Weekendkamp - 12-14 februari</li>
                            <li>Vriendenwerving - 5 maart</li>
                        </ul>
                    </div>
                </div>

                <div style="width:380px;">
                    <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,0.06);margin-bottom:16px;">
                        <h4 style="margin:0 0 12px;color:#111;font-size:1.125rem;font-weight:600;">Recente nieuwsberichten</h4>
                        @php
                            $recent = \App\Models\NewsItem::orderBy('published_at','desc')->take(5)->get();
                        @endphp

                        @if($recent->isEmpty())
                            <p style="color:#6b7280;">Er zijn nog geen nieuwsberichten. Als admin kun je deze aanmaken via het admin paneel.</p>
                        @else
                            <ul style="margin:0;padding-left:18px;color:#374151;">
                                @foreach($recent as $item)
                                    <li style="margin-bottom:8px;">
                                        <a href="{{ route('news.show', $item) }}" style="color:#1f2937;font-weight:600;text-decoration:none;">{{ $item->title }}</a>
                                        <div style="font-size:0.875rem;color:#6b7280;">{{ $item->published_at->format('d M Y') }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
                        <h4 style="margin:0 0 12px;color:#111;font-size:1.125rem;font-weight:600;">Veelgestelde vragen</h4>
                        @php
                            $faqs = \App\Models\FaqItem::orderBy('id','desc')->take(5)->get();
                        @endphp

                        @if($faqs->isEmpty())
                            <p style="color:#6b7280;">Nog geen FAQ items beschikbaar.</p>
                        @else
                            <ul style="margin:0;padding-left:18px;color:#374151;">
                                @foreach($faqs as $faq)
                                    <li style="margin-bottom:8px;">
                                        <div style="font-weight:600;">{{ $faq->question }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
