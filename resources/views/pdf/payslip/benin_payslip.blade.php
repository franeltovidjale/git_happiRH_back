<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bulletin de Paie - {{ $employee_name ?? 'Employé' }}</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    @include('pdf.payslip.styles')
</head>

<body>
    <div class="payslip-container">
        <!-- Header Section -->
        @include('pdf.payslip.header', $data ?? [])

        <!-- Body Section - Details de la paie -->
        <table class="main-table">
            <tr>
                <td class="table-spacing">
                    @include('pdf.payslip.body', $data ?? [])
                </td>
            </tr>
        </table>

        <!-- Footer Section -->
        <table class="main-table">
            <tr>
                <td>
                    @include('pdf.payslip.footer', $data ?? [])
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
