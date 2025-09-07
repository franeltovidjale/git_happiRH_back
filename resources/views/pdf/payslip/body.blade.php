<div class="section-title">
    DÉTAILS DE LA PAIE
</div>

<table class="payroll-table">
    <thead>
        <tr>
            <th>CODE</th>
            <th>LIBELLES</th>
            <th>BASES OU NOMBRES</th>
            <th>TAUX OU %</th>
            <th>MONTANTS A AJOUTER</th>
            <th>MONTANTS A DEDUIRE</th>
            <th>CHARGES TAUX</th>
            <th>PATRONALES MONTANTS</th>
            <th>DATE EVENEMENTS QUANTITES</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($payroll_lines) && is_array($payroll_lines))
            @foreach($payroll_lines as $line)
                <tr>
                    <td class="text-center">{{ $line['code'] ?? '' }}</td>
                    <td class="text-left">{{ $line['label'] ?? '' }}</td>
                    <td class="text-right">{{ $line['base'] ?? '' }}</td>
                    <td class="text-right">{{ $line['rate'] ?? '' }}</td>
                    <td class="text-right">{{ $line['addition'] ?? '' }}</td>
                    <td class="text-right">{{ $line['deduction'] ?? '' }}</td>
                    <td class="text-right">{{ $line['employer_rate'] ?? '' }}</td>
                    <td class="text-right">{{ $line['employer_amount'] ?? '' }}</td>
                    <td class="text-center">{{ $line['date_event'] ?? '' }}</td>
                </tr>
            @endforeach
        @else
            <!-- Lignes par défaut -->
            <tr>
                <td class="text-center">0012</td>
                <td class="text-left">SAL. DE BASE MENS.</td>
                <td class="text-right"></td>
                <td class="text-right">100,000</td>
                <td class="text-right">500000</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">P 01/10</td>
            </tr>
            <tr>
                <td class="text-center">0122</td>
                <td class="text-left">IND.DEPLACEMENT</td>
                <td class="text-right">23,00</td>
                <td class="text-right">25000,000</td>
                <td class="text-right">25000</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">P 02/10</td>
            </tr>
            <tr>
                <td class="text-center">0238</td>
                <td class="text-left">ANCIENNETE</td>
                <td class="text-right">525000,00</td>
                <td class="text-right">5,000</td>
                <td class="text-right">26250</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">P 03/10</td>
            </tr>
            <tr>
                <td class="text-center">0478</td>
                <td class="text-left">C.N.S.S.</td>
                <td class="text-right">551250,00</td>
                <td class="text-right">3,600</td>
                <td class="text-right"></td>
                <td class="text-right">19845</td>
                <td class="text-right">6,400</td>
                <td class="text-right">35280</td>
                <td class="text-center">P 04/10</td>
            </tr>
            <tr>
                <td class="text-center">0550</td>
                <td class="text-left">MUTUELLE SANTE</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">1750</td>
                <td class="text-right"></td>
                <td class="text-right">5250</td>
                <td class="text-center">P 05/10</td>
            </tr>
            <tr>
                <td class="text-center">0632</td>
                <td class="text-left">AVANCES ET PRETS</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">81818</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">NOP 06/10</td>
            </tr>
            <tr>
                <td class="text-center">0664</td>
                <td class="text-left">IMPOT ITS</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">86800</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">P 07/10</td>
            </tr>
            <tr>
                <td class="text-center">0925</td>
                <td class="text-left">FRAIS BANCAIRE</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">550</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">P 08/10</td>
            </tr>
            <tr>
                <td class="text-center">0680</td>
                <td class="text-right">VERSEMENT PATRONAL</td>
                <td class="text-right">551250,00</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">4,000</td>
                <td class="text-right">22050</td>
                <td class="text-center">P 09/10</td>
            </tr>
            <tr>
                <td class="text-center">0684</td>
                <td class="text-left">PRESTATIONS FAMILIALES</td>
                <td class="text-right">551250,00</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">9,000</td>
                <td class="text-right">49613</td>
                <td class="text-center">P 10/10</td>
            </tr>
            <tr>
                <td class="text-center">0686</td>
                <td class="text-left">RISQUES PROFESSIONNELS</td>
                <td class="text-right">551250,00</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">4,000</td>
                <td class="text-right">22050</td>
                <td class="text-center">P 11/10</td>
            </tr>
            <tr>
                <td class="text-center">0933</td>
                <td class="text-left">APPOINT MS PRECT</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">480</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">P 12/10</td>
            </tr>
            <tr>
                <td class="text-center">0934</td>
                <td class="text-left">APPOINT DU MOIS</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">393</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">NOP 13/10</td>
            </tr>
            <tr>
                <td class="text-center">1090</td>
                <td class="text-left">ACQUIS CP</td>
                <td class="text-right">65,00</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">P 14/10</td>
            </tr>
            <tr>
                <td class="text-center">1100</td>
                <td class="text-left">SOLDE CP</td>
                <td class="text-right">65,00</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-center">P 15/10</td>
            </tr>
        @endif
        
        <tr class="subtotal-row">
            <td colspan="4" class="text-right">SOUS TOTAUX</td>
            <td class="text-right">{{ number_format($subtotal_additions ?? 552193, 0, ',', ' ') }}</td>
            <td class="text-right">{{ number_format($subtotal_deductions ?? 190693, 0, ',', ' ') }}</td>
            <td class="text-right"></td>
            <td class="text-right">{{ number_format($subtotal_employer ?? 134243, 0, ',', ' ') }}</td>
            <td class="text-center"></td>
        </tr>
    </tbody>
</table>

<div class="net-pay">
    NET A PAYER<br>
    ***{{ number_format($net_pay ?? 361500, 0, ',', ' ') }}
</div>