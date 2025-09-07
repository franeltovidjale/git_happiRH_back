<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin de Paie - Entête</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .payslip-header {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border: 2px solid #4169E1;
            border-collapse: collapse;
        }

        .main-title {
            background: #4169E1;
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding: 12px;
            letter-spacing: 2px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table td {
            vertical-align: top;
            padding: 0;
        }

        .sub-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sub-table td {
            border: 2px solid #4169E1;
            background: #f8f9ff;
            vertical-align: top;
            padding: 8px;
        }

        .card-content {
            padding: 15px;
        }

        .company-section {
            text-align: left;
        }

        .logo-container {
            float: left;
            margin-right: 15px;
        }

        .logo {
            background: white;
            padding: 8px 12px;
            border: 1px solid #ddd;
        }

        .logo-symbol {
            float: left;
            margin-right: 8px;
        }

        .red-triangle {
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 12px solid #FF4444;
            float: left;
            margin-right: 2px;
        }

        .blue-triangle {
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 12px solid #4169E1;
            float: left;
        }

        .logo-text {
            font-weight: bold;
            font-size: 16px;
            color: #4169E1;
            float: left;
            margin-left: 8px;
            line-height: 12px;
        }

        .company-info {
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .social-section {
            background: #e6f0ff;
            text-align: center;
        }

        .social-title {
            color: #4169E1;
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 8px;
        }

        .social-info {
            font-size: 11px;
            line-height: 1.3;
            color: #333;
        }

        .period-section {
            background: #e6f0ff;
            text-align: right;
        }

        .period-title {
            color: #4169E1;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .period-info {
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .period-dates {
            margin: 8px 0;
        }

        .redacted {
            background: #000;
            color: #000;
            padding: 2px 15px;
            display: inline-block;
        }

        .blue-text {
            color: #4169E1;
            font-weight: bold;
        }

        .establishment-section {
            padding: 15px;
        }

        .establishment-title {
            color: #4169E1;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .establishment-info {
            font-size: 11px;
            line-height: 1.3;
            color: #333;
        }

        .siret-info {
            margin: 8px 0;
            font-size: 10px;
        }

        .convention-title {
            color: #4169E1;
            font-weight: bold;
            font-size: 11px;
            margin: 8px 0 4px 0;
        }

        .employee-section {
            background: #e6f0ff;
            padding: 15px;
        }

        .appointment-title {
            color: #4169E1;
            font-weight: bold;
            font-size: 12px;
        }

        .appointment-value {
            font-weight: bold;
            font-size: 12px;
            float: right;
        }

        .employee-row {
            margin: 8px 0;
            font-size: 11px;
            clear: both;
        }

        .employee-label {
            color: #4169E1;
            font-weight: bold;
        }

        .qualification-header {
            color: #4169E1;
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 5px;
        }

        .qualification-values {
            font-size: 11px;
            color: #333;
        }

        .employee-details {
            margin: 10px 0;
            font-size: 11px;
            line-height: 1.3;
        }

        .ifu-section {
            margin: 8px 0;
            font-size: 11px;
        }

        .family-info {
            font-size: 11px;
            color: #333;
        }

        .clear {
            clear: both;
        }

        .three-col {
            width: 33.33%;
        }

        .two-col {
            width: 50%;
        }
    </style>
</head>
<body>
    <div class="payslip-header">
        <div class="main-title">BULLETIN DE PAIE</div>
        
        <table class="main-table">
            <!-- Tableau 1: SOGEA SATOM, LIEU DE PAIEMENT, PERIODE -->
            <tr>
                <td>
                    <table class="sub-table">
                        <tr>
                            <td class="three-col">
                                <div class="card-content company-section">
                                    <div class="logo-container">
                                        <div class="logo">
                                            <div class="logo-symbol">
                                                <div class="red-triangle"></div>
                                                <div class="blue-triangle"></div>
                                            </div>
                                            <div class="logo-text">SOGEA SATOM</div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="company-info">
                                        <div><strong>SOGEA-SATOM SA</strong></div>
                                        <div>01 B P 2190</div>
                                        <div>COTONOU TEL: 21-33-00-94</div>
                                        <div>. R. BENIN</div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </td>
                            <td class="three-col">
                                <div class="card-content social-section">
                                    <div class="social-title">LIEU DE PAIEMENT DES COTISATIONS SOCIALES</div>
                                    <div class="social-info">
                                        <div>C.N.S.S.</div>
                                        <div>BP 374</div>
                                        <div>.</div>
                                    </div>
                                </div>
                            </td>
                            <td class="three-col">
                                <div class="card-content period-section">
                                    <div class="period-title">PERIODE:</div>
                                    <div class="period-info">
                                        <div class="blue-text">OCTOBRE 2024</div>
                                        <div class="period-dates">
                                            <span class="blue-text">DU</span> 01/10/2 
                                            <span class="blue-text">AU</span> 31/10/24
                                        </div>
                                        <div><span class="blue-text">MATRICULE</span> <span class="redacted">______</span></div>
                                        <div><span class="blue-text">ANCIENNETE:</span> 01/12/17</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Tableau 2: ETABLISSEMENT, CONVENTION COLLECTIVE, APPOINTEMENTS -->
            <tr>
                <td>
                    <table class="sub-table">
                        <tr>
                            <td class="three-col">
                                <div class="card-content establishment-section">
                                    <div class="establishment-title">ETABLISSEMENT :</div>
                                    <div class="establishment-info">
                                        <div>S A T O M  B E N I N</div>
                                        <div>B.P. 2190</div>
                                        <div>COTONOU</div>
                                        <div>TEL: 33 00 94</div>
                                    </div>
                                    <div class="siret-info">
                                        <div><span class="blue-text">SIRET :</span> 1&nbsp;&nbsp;&nbsp;&nbsp;00001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="blue-text">NAF :</span> .</div>
                                    </div>
                                </div>
                            </td>
                            <td class="three-col">
                                <div class="card-content establishment-section">
                                    <div class="convention-title">CONVENTION COLLECTIVE</div>
                                    <div>BATIMENT ET T.P.</div>
                                </div>
                            </td>
                            <td class="three-col">
                                <div class="card-content employee-section">
                                    <div class="appointment-title">APPOINTEMENTS / HORAIRE :</div>
                                    <div class="appointment-value">500000</div>
                                    <div class="clear"></div>
                                    
                                    <div class="employee-row">
                                        <span class="employee-label">EMPLOI :</span>
                                        <span class="redacted">_____________</span>
                                    </div>
                                    
                                    <div class="employee-row">
                                        C. de calcul <span class="redacted">_______________</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Tableau 3: QUALIFICATION et DETAILS EMPLOYE -->
            <tr>
                <td>
                    <table class="sub-table">
                        <tr>
                            <td class="two-col">
                                <div class="card-content employee-section">
                                    <div class="qualification-header">
                                        QUALIFICATION&nbsp;&nbsp;&nbsp;&nbsp;NIVEAU&nbsp;&nbsp;&nbsp;&nbsp;POSIT&nbsp;&nbsp;&nbsp;&nbsp;COEFFICIENTS&nbsp;&nbsp;&nbsp;&nbsp;N° SECURITE
                                    </div>
                                    <div class="qualification-values">
                                        AGENT DE MAITRISE 5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="redacted">_____________</span>
                                    </div>
                                </div>
                            </td>
                            <td class="two-col">
                                <div class="card-content employee-section">
                                    <div class="employee-details">
                                        <div><span class="redacted">_________________________</span></div>
                                        <div>00000 COTONOU</div>
                                        <div>BENIN</div>
                                    </div>

                                    <div class="ifu-section">
                                        N° IFU <span class="redacted">_____________</span>&nbsp;&nbsp;&nbsp;&nbsp;MUTUELLE :
                                    </div>

                                    <div class="family-info">
                                        Sit.fam: C&nbsp;&nbsp;Nb enf.: 00&nbsp;&nbsp;Nb ded.fiscale: 00
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Tableau 4: DÉTAILS DE LA PAIE -->
            <tr>
                <td>
                    <div style="margin-top: 10px;">
                        <div style="background: #4169E1; color: white; text-align: center; font-size: 14px; font-weight: bold; padding: 8px; margin-bottom: 5px;">
                            DÉTAILS DE LA PAIE
                        </div>
                        <table style="width: 100%; border-collapse: collapse; border: 2px solid #4169E1; font-size: 9px;">
                            <thead>
                                <tr style="background: #4169E1; color: white;">
                                    <th style="border: 1px solid #4169E1; padding: 6px 4px; text-align: center; font-weight: bold;">CODE</th>
                                    <th style="border: 1px solid #4169E1; padding: 6px 4px; text-align: center; font-weight: bold;">LIBELLES</th>
                                    <th style="border: 1px solid #4169E1; padding: 6px 4px; text-align: center; font-weight: bold;">BASES OU NOMBRES</th>
                                    <th style="border: 1px solid #4169E1; padding: 6px 4px; text-align: center; font-weight: bold;">TAUX OU %</th>
                                    <th style="border: 1px solid #4169E1; padding: 6px 4px; text-align: center; font-weight: bold;">MONTANTS A AJOUTER</th>
                                    <th style="border: 1px solid #4169E1; padding: 6px 4px; text-align: center; font-weight: bold;">MONTANTS A DEDUIRE</th>
                                    <th style="border: 1px solid #4169E1; padding: 6px 4px; text-align: center; font-weight: bold;">CHARGES TAUX</th>
                                    <th style="border: 1px solid #4169E1; padding: 6px 4px; text-align: center; font-weight: bold;">PATRONALES MONTANTS</th>
                                    <th style="border: 1px solid #4169E1; padding: 6px 4px; text-align: center; font-weight: bold;">DATE EVENEMENTS QUANTITES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0012</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">SAL. DE BASE MENS.</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">100,000</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">500000</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 01/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0122</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">IND.DEPLACEMENT</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">23,00</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">25000,000</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">25000</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 02/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0238</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">ANCIENNETE</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">525000,00</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">5,000</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">26250</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 03/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0478</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">C.N.S.S.</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">551250,00</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">3,600</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">19845</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">6,400</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">35280</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 04/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0550</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">MUTUELLE SANTE</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">1750</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">5250</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 05/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0632</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">AVANCES ET PRETS</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">81818</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">NOP 06/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0664</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">IMPOT ITS</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">86800</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 07/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0925</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">FRAIS BANCAIRE</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">550</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 08/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0680</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">VERSEMENT PATRONAL</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">551250,00</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">4,000</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">22050</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 09/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0684</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">PRESTATIONS FAMILIALES</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">551250,00</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">9,000</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">49613</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 10/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0686</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">RISQUES PROFESSIONNELS</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">551250,00</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">4,000</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">22050</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 11/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0933</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">APPOINT MS PRECT</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">480</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 12/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">0934</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">APPOINT DU MOIS</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">393</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">NOP 13/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">1090</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">ACQUIS CP</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">65,00</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 14/10</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">1100</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: left;">SOLDE CP</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">65,00</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;">P 15/10</td>
                                </tr>
                                <tr style="background: #f0f8ff; font-weight: bold;">
                                    <td colspan="4" style="border: 1px solid #ccc; padding: 4px; text-align: right;">SOUS TOTAUX</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">552193</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">190693</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;"></td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">134243</td>
                                    <td style="border: 1px solid #ccc; padding: 4px; text-align: center;"></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- NET A PAYER -->
                        <div style="background: #4169E1; color: white; text-align: center; font-size: 16px; font-weight: bold; padding: 10px; margin: 10px 0;">
                            NET A PAYER<br>
                            ***361500
                        </div>

                        <!-- TABLEAU MODE DE REGLEMENT -->
                        <table style="width: 100%; border-collapse: collapse; border: 2px solid #4169E1; margin-top: 10px; font-size: 10px;">
                            <thead>
                                <tr style="background: #4169E1; color: white;">
                                    <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">MODE DE REGLEMENT</th>
                                    <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">DATE DE REGLEMENT</th>
                                    <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">CODE BANQUE</th>
                                    <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">CODE GUICHET</th>
                                    <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">N° DE COMPTE</th>
                                    <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">DOMICILIATION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; padding: 8px; text-align: center; background: #f8f9ff;">VIREMENTS</td>
                                    <td style="border: 1px solid #ccc; padding: 8px; text-align: center; background: #f8f9ff;">31/10/24</td>
                                    <td style="border: 1px solid #ccc; padding: 8px; text-align: center; background: #f8f9ff;">BJ061</td>
                                    <td style="border: 1px solid #ccc; padding: 8px; text-align: center; background: #f8f9ff;">01004</td>
                                    <td style="border: 1px solid #ccc; padding: 8px; text-align: center; background: #f8f9ff;"><span style="background: #000; color: #000; padding: 2px 15px;">0784722000150</span></td>
                                    <td style="border: 1px solid #ccc; padding: 8px; text-align: center; background: #f8f9ff;">BANK OF AFRICA</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- TABLEAU FINAL LIBELLES -->
                        <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px;">
                            <tr>
                                <td style="width: 50%; vertical-align: top; padding-right: 5px;">
                                    <table style="width: 100%; border: 2px solid #4169E1; border-collapse: collapse; background: #f8f9ff;">
                                        <thead>
                                            <tr style="background: #4169E1; color: white;">
                                                <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">LIBELLES</th>
                                                <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">MOIS</th>
                                                <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">CUMULS ANNUELS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="border: 1px solid #ccc; padding: 20px; text-align: center; background: #f8f9ff;">&nbsp;</td>
                                                <td style="border: 1px solid #ccc; padding: 20px; text-align: center; background: #f8f9ff;">&nbsp;</td>
                                                <td style="border: 1px solid #ccc; padding: 20px; text-align: center; background: #f8f9ff;">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width: 50%; vertical-align: top; padding-left: 5px;">
                                    <table style="width: 100%; border: 2px solid #4169E1; border-collapse: collapse; background: #f8f9ff;">
                                        <thead>
                                            <tr style="background: #4169E1; color: white;">
                                                <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">LIBELLES</th>
                                                <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">MOIS</th>
                                                <th style="border: 1px solid #4169E1; padding: 8px; text-align: center; font-weight: bold;">CUMULS ANNUELS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="border: 1px solid #ccc; padding: 8px; text-align: left; background: #f8f9ff;">BASE IMPOSABLE</td>
                                                <td style="border: 1px solid #ccc; padding: 8px; text-align: center; background: #f8f9ff;">551250</td>
                                                <td style="border: 1px solid #ccc; padding: 8px; text-align: center; background: #f8f9ff;">551250</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- FOOTER 1/1 -->
                        <div style="text-align: center; font-size: 10px; margin-top: 15px; color: #666;">
                            1/1
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>