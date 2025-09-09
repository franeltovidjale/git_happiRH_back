<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        padding: 20px;
        font-family: "Inter", sans-serif;
        font-size: 12px;
    }

    .payslip-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        border-collapse: collapse;
    }

    .main-title {
        color: black;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        padding: 12px;
        letter-spacing: 2px;
    }

    .section-title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        padding: 10px;
        margin: 15px 0 10px 0;
    }

    .main-table {
        width: 100%;
        border-collapse: collapse;
    }

    .main-table td {
        vertical-align: top;
        padding: 0;
    }

    .table-spacing {
        margin-bottom: 15px;
    }

    .sub-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 10px;
    }

    .sub-table td {
        border: 1px solid #dcdee2;
        vertical-align: top;
        padding: 12px 15px;
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
        border-bottom: 12px solid #dcdee2;
        float: left;
    }

    .logo-text {
        font-weight: bold;
        font-size: 16px;
        color: #4169E1;
        float: left;
        margin-left: 8px;
    }

    .company-info {
        font-size: 12px;
        color: #333;
    }

    .social-section {
        text-align: center;
    }

    .social-title {
        color: #000000;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .social-info {
        color: #333;
    }

    .period-section {
        text-align: right;
    }

    .period-title {
        color: #000000;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .period-info {
        color: #333;
    }

    .period-dates {
        margin: 8px 0;
    }

    .redacted {
        color: #000;
        padding: 2px 15px;
        display: inline-block;
    }

    .blue-text {
        color: #000000;
        font-weight: bold;
    }

    .establishment-section {
        padding: 15px;
    }

    .establishment-title {
        color: #4169E1;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .establishment-info {
        color: #333;
    }

    .siret-info {
        margin: 8px 0;
    }

    .convention-title {
        color: #4169E1;
        font-weight: bold;
        margin: 8px 0 4px 0;
    }

    .employee-section {
        padding: 15px;
    }

    .appointment-title {
        font-weight: bold;
    }

    .appointment-value {
        font-weight: bold;
        float: right;
    }

    .employee-row {
        margin: 8px 0;
        clear: both;
    }

    .employee-label {
        font-weight: bold;
    }

    .qualification-header {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .qualification-values {
        color: #333;
    }

    .employee-details {
        margin: 10px 0;
    }

    .ifu-section {
        margin: 8px 0;
    }

    .family-info {
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

    .title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .subtitle {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .text {
        font-size: 12px;
        margin-bottom: 4px;
    }

    /* Body styles */
    .payroll-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #dcdee2;
        margin-top: 10px;
    }

    .payroll-table th {
        border: 1px solid #dcdee2;
        padding: 6px 4px;
        text-align: center;
        font-weight: bold;

    }

    .payroll-table td {
        border: 1px solid #ccc;
        padding: 4px;
    }

    .payroll-table .text-center {
        text-align: center;
    }

    .payroll-table .text-left {
        text-align: left;
    }

    .payroll-table .text-right {
        text-align: right;
    }

    .subtotal-row {
        font-weight: bold;
    }

    .net-pay {
        text-align: center;
        font-weight: bold;
        padding: 10px;
        margin: 10px 0;
    }

    /* Footer styles */
    .payment-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #dcdee2;
        margin-top: 10px;
    }

    .payment-table th {
        border: 1px solid #dcdee2;
        padding: 8px;
        text-align: center;
        font-weight: bold;
        color: white;
    }

    .payment-table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    .summary-table {
        width: 100%;
        border: 1px solid #dcdee2;
        border-collapse: collapse;
    }

    .summary-table th {
        border: 1px solid #dcdee2;
        padding: 8px;
        text-align: center;
        font-weight: bold;
    }

    .summary-table td {
        border: 1px solid #ccc;
        padding: 8px;
    }

    .footer-page {
        text-align: center;
        margin-top: 15px;
        color: #666;
    }

    .two-column-layout {
        width: 100%;
        margin-top: 10px;
    }

    .two-column-layout td {
        width: 50%;
        vertical-align: top;
    }

    .two-column-layout td:first-child {
        padding-right: 5px;
    }

    .two-column-layout td:last-child {
        padding-left: 5px;
    }
</style>
