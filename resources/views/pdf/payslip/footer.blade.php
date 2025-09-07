<!-- Mode de règlement -->
<table class="payment-table">
    <thead>
        <tr>
            <th>MODE DE REGLEMENT</th>
            <th>DATE DE REGLEMENT</th>
            <th>CODE BANQUE</th>
            <th>CODE GUICHET</th>
            <th>N° DE COMPTE</th>
            <th>DOMICILIATION</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $payment_method ?? 'VIREMENTS' }}</td>
            <td>{{ $payment_date ?? '31/10/24' }}</td>
            <td>{{ $bank_code ?? 'BJ061' }}</td>
            <td>{{ $branch_code ?? '01004' }}</td>
            <td><span class="redacted">{{ $account_number ?? '0784722000150' }}</span></td>
            <td>{{ $bank_name ?? 'BANK OF AFRICA' }}</td>
        </tr>
    </tbody>
</table>

<!-- Tableaux récapitulatifs -->
<table class="two-column-layout">
    <tr>
        <td>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>LIBELLES</th>
                        <th>MOIS</th>
                        <th>CUMULS ANNUELS</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($left_summary) && is_array($left_summary))
                        @foreach($left_summary as $item)
                            <tr>
                                <td class="text-left">{{ $item['label'] ?? '' }}</td>
                                <td class="text-center">{{ $item['month'] ?? '' }}</td>
                                <td class="text-center">{{ $item['annual'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </td>
        <td>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>LIBELLES</th>
                        <th>MOIS</th>
                        <th>CUMULS ANNUELS</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($right_summary) && is_array($right_summary))
                        @foreach($right_summary as $item)
                            <tr>
                                <td class="text-left">{{ $item['label'] ?? '' }}</td>
                                <td class="text-center">{{ $item['month'] ?? '' }}</td>
                                <td class="text-center">{{ $item['annual'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-left">BASE IMPOSABLE</td>
                            <td class="text-center">{{ number_format($taxable_base ?? 551250, 0, ',', ' ') }}</td>
                            <td class="text-center">{{ number_format($taxable_base_annual ?? 551250, 0, ',', ' ') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </td>
    </tr>
</table>

<!-- Pagination -->
<div class="footer-page">
    {{ $page_number ?? '1/1' }}
</div>