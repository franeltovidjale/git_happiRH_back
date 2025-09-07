<div class="title" style="text-align: center; margin-bottom: 20px;">BULLETIN DE PAIE</div>

<table class="main-table">
    <!-- Section 1: Informations de l'entreprise, Lieu de paiement, Période -->
    <tr>
        <td class="table-spacing">
            <table class="sub-table">
                <tr>
                    <td class="three-col">
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
                        <div class="subtitle">{{ $company_name ?? 'SOGEA-SATOM SA' }}</div>
                        <div class="text">{{ $company_address ?? '01 B P 2190' }}</div>
                        <div class="text">{{ $company_city ?? 'COTONOU' }} TEL: {{ $company_phone ?? '21-33-00-94' }}</div>
                        <div class="text">. R. {{ $company_country ?? 'BENIN' }}</div>
                    </td>
                    <td class="three-col" style="text-align: center;">
                        <div class="subtitle">LIEU DE PAIEMENT DES COTISATIONS SOCIALES</div>
                        <div class="text">{{ $social_place ?? 'C.N.S.S.' }}</div>
                        <div class="text">{{ $social_address ?? 'BP 374' }}</div>
                        <div class="text">.</div>
                    </td>
                    <td class="three-col" style="text-align: right;">
                        <div class="subtitle">PERIODE:</div>
                        <div class="subtitle" style="color: #4169E1;">{{ strtoupper($period ?? 'OCTOBRE 2024') }}</div>
                        <div class="text" style="margin: 8px 0;">
                            <strong>DU</strong> {{ $period_start ?? '01/10/2024' }}
                            <strong>AU</strong> {{ $period_end ?? '31/10/24' }}
                        </div>
                        <div class="text"><strong>MATRICULE</strong> <span class="redacted">{{ $employee_id ?? '______' }}</span></div>
                        <div class="text"><strong>ANCIENNETE:</strong> {{ $seniority_date ?? '01/12/17' }}</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Section 2: Établissement, Convention collective, Appointements -->
    <tr>
        <td class="table-spacing">
            <table class="sub-table">
                <tr>
                    <td class="three-col">
                        <div class="subtitle" style="color: #4169E1;">ETABLISSEMENT :</div>
                        <div class="text">{{ $establishment_name ?? 'S A T O M  B E N I N' }}</div>
                        <div class="text">{{ $establishment_address ?? 'B.P. 2190' }}</div>
                        <div class="text">{{ $establishment_city ?? 'COTONOU' }}</div>
                        <div class="text">TEL: {{ $establishment_phone ?? '33 00 94' }}</div>
                        <div class="text" style="margin-top: 8px;">
                            <strong>SIRET :</strong> {{ $siret ?? '1    00001        ' }}
                            <strong>NAF :</strong> {{ $naf ?? '.' }}
                        </div>
                    </td>
                    <td class="three-col" style="text-align: center;">
                        <div class="subtitle" style="color: #4169E1;">CONVENTION COLLECTIVE</div>
                        <div class="text" style="font-weight: 600;">{{ $collective_agreement ?? 'BATIMENT ET T.P.' }}</div>
                    </td>
                    <td class="three-col">
                        <div class="subtitle">APPOINTEMENTS / HORAIRE :</div>
                        <div class="title" style="text-align: right; color: #4169E1; margin-bottom: 12px;">
                            {{ number_format($salary ?? 500000, 0, ',', ' ') }}
                        </div>
                        <div class="text">
                            <strong>EMPLOI :</strong>
                            <span class="redacted">{{ $job_title ?? '_____________' }}</span>
                        </div>
                        <div class="text">
                            <strong>C. de calcul</strong> <span class="redacted">{{ $calculation_code ?? '_______________' }}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Section 3: Qualification et Détails employé -->
    <tr>
        <td class="table-spacing">
            <table class="sub-table">
                <tr>
                    <td class="two-col">
                        <div class="subtitle" style="color: #4169E1; margin-bottom: 8px;">
                            QUALIFICATION - NIVEAU - POSIT - COEFFICIENTS - N° SECURITE
                        </div>
                        <div class="text" style="display: flex; justify-content: space-between; align-items: center;">
                            <span>{{ $qualification ?? 'AGENT DE MAITRISE 5' }}</span>
                            <span class="redacted">{{ $security_number ?? '_____________' }}</span>
                        </div>
                    </td>
                    <td class="two-col">
                        <div class="text" style="margin-bottom: 8px;">
                            <span class="redacted">{{ $employee_name ?? '_________________________' }}</span>
                        </div>
                        <div class="text">{{ $employee_postal ?? '00000' }} {{ $employee_city ?? 'COTONOU' }}</div>
                        <div class="text">{{ $employee_country ?? 'BENIN' }}</div>

                        <div class="text" style="margin-top: 8px;">
                            <strong>N° IFU</strong> <span class="redacted">{{ $ifu_number ?? '_____________' }}</span>
                            <strong style="margin-left: 20px;">MUTUELLE :</strong> {{ $mutual ?? '' }}
                        </div>

                        <div class="text" style="margin-top: 6px;">
                            <strong>Sit.fam:</strong> {{ $family_status ?? 'C' }}
                            <strong style="margin-left: 15px;">Nb enf.:</strong> {{ $children_count ?? '00' }}
                            <strong style="margin-left: 15px;">Nb ded.fiscale:</strong> {{ $tax_deductions ?? '00' }}
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>