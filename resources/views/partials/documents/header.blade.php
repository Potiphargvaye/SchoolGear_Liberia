<div class="header">
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @if ($branding['logo'])
                    <img src="{{ $forPdf ? public_path('storage/' . $branding['logo']) : asset('storage/' . $branding['logo']) }}"
                        alt="{{ $branding['name'] }}">
                @endif
            </td>

            <td class="header-text-cell">
                <div class="school-name">{{ strtoupper($branding['name']) }}</div>
                @if ($branding['address'])
                    <div class="school-address">{{ $branding['address'] }}</div>
                @endif
                @if ($branding['po_box'])
                    <div class="school-address">{{ $branding['po_box'] }}</div>
                @endif
                <div class="school-address">
                    @if ($branding['phone'])
                        {{ $branding['phone'] }}
                    @endif
                    @if ($branding['phone'] && $branding['email'])
                        &nbsp;|&nbsp;
                    @endif
                    @if ($branding['email'])
                        {{ $branding['email'] }}
                    @endif
                </div>
                @if ($branding['website'] || $branding['school_number'])
                    <div class="school-address">
                        @if ($branding['website'])
                            {{ $branding['website'] }}
                        @endif
                        @if ($branding['website'] && $branding['school_number'])
                            &nbsp;|&nbsp;
                        @endif
                        @if ($branding['school_number'])
                            {{ $branding['school_number'] }}
                        @endif
                    </div>
                @endif
                <div class="receipt-title">{{ $documentTitle }}</div>
                @isset($documentCaption)
                    @if ($documentCaption)
                        <div class="receipt-caption">{{ $documentCaption }}</div>
                    @endif
                @endisset
                @isset($documentDate)
                    <div class="receipt-date">Date: {{ $documentDate }}</div>
                @endisset
            </td>
            <td class="logo-cell"></td>
        </tr>
    </table>
    <div class="divider"></div>
</div>

<div class="footer">
    <div>Printed on {{ now()->format('M d, Y') }} at {{ now()->format('h:i A') }}</div>
    <div>{{ $branding['footer']['note'] }}</div>
</div>
