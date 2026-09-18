<div class="footer-contact">
    <table class="footer-table">
        <tr>
            <td>
                <span class="footer-label">{{ $branding['footer']['location_label'] }}</span>
                {{ $branding['footer']['location'] }}
            </td>
            <td>
                <span class="footer-label">{{ $branding['footer']['call_label'] }}</span>
                {{ $branding['footer']['call'] }}<br>
                <span style="color:#8499b6;">Mon - Fri, 8:00 AM - 5:00 PM</span>
            </td>
            <td>
                <span class="footer-label">{{ $branding['footer']['email_label'] }}</span>
                {{ $branding['footer']['email'] }}
            </td>
        </tr>
    </table>
</div>

<div class="footer">
    <div>Printed on {{ now()->format('M d, Y') }} at {{ now()->format('h:i A') }}</div>
    <div>{{ $branding['footer']['note'] }}</div>
</div>
