<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }}</title>
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawsome/css/all.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            /* Added Roboto font */
            margin: 0;
            padding: 0;
        }


        .invoice {
            max-width: 795px;
            /* Sesuaikan dengan lebar kertas A4 */
            margin: 20px auto;
            padding: 40px;
            /* border: 2px solid #ccc;  */
            height: 1123px;
        }

        .header {
            display: flex;
            justify-content: space-between;
        }

        .header img {
            width: 72px;
            height: 56px;
            opacity: 0px;
        }

        .header h1 {
            font-size: 30px;
            color: #F2CEC2;
            font-weight: bolder;
        }

        .companyInfo {
            margin-top: -25px;
            width: 280px;
            /* Atur jarak kanan */
        }

        .companyInfo h5 {
            margin-bottom: 5px;
            /* Atur jarak bawah h5 */
            font-weight: 700;
            font-size: 15px;
        }

        .companyInfo p {
            margin-top: 5px;
            /* Atur jarak atas p */
            font-size: 12px;
            font-weight: 400;
            color: #2B2C2E;
        }

        .circle {
            display: inline-block;
            width: 30px;
            /* Adjust the size of the circle */
            height: 30px;
            /* Adjust the size of the circle */
            background-color: rgba(222, 65, 15, 0.2);
            /* Set opacity here */
            border-radius: 50%;
            /* Makes it a circle */
            text-align: center;
            line-height: 30px;
            /* Center the icon vertically */
        }

        .circle i {
            color: #772D2F;
        }

        .companySocial {
            display: flex;
            justify-content: space-between;
        }

        .companyMail {
            font-size: 13px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .invText {
            font-size: 16px;
            color: #772D2F;
        }

        .invx {
            margin-top: -25px;
            width: 280px;
            /* Atur jarak kanan */
        }

        .invx h5 {
            margin-bottom: 5px;
            /* Atur jarak bawah h5 */
            font-weight: 700;
            font-size: 15px;
        }

        .invx h6 {
            margin-top: 5px;
            margin-bottom: 5px;
            /* Atur jarak bawah h5 */
            font-weight: 700;
            font-size: 12px;
        }

        .invx p {
            margin-top: 5px;
            /* Atur jarak atas p */
            font-size: 12px;
            font-weight: 400;
            color: #2B2C2E;
        }

        .desc {
            display: flex;
            justify-content: space-between;
        }

        .description .invText {
            text-align: end;
        }

        .description {
            text-align: justify;
        }

        .tableInfo {
            display: flex;
            justify-content: end;
            margin-top: 50px;
        }

        .table {
            width: 75%;
            border-collapse: collapse;
        }

        .table thead th {
            padding: 0.75rem;
            vertical-align: top;
            border: 3px solid white;
            /* Set border color of cells to white and increase width */
        }

        .table tbody td {
            padding: 0.1rem;
            padding-right: 8px;
            vertical-align: top;
            border: 3px solid white;
            /* Set border color of cells to white and increase width */
        }

        .table tfoot td {
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 8px;
            vertical-align: top;
        }

        .table thead td {
            text-align: center;
            /* Center align the text in the <thead> */
            vertical-align: bottom;
            border-bottom: 3px solid white;
            /* Set header bottom border color to white and increase width */
        }

        .table tbody+tbody {
            border-top: 3px solid white;
            /* Set border between table body sections to white and increase width */
        }

        .table thead {
            background-color: rgba(222, 65, 15, 0.2);
            /* Set opacity here */
        }

        .table thead .text {
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .table thead .info {
            font-size: 14px;
            color: #772D2F;
            font-weight: bold;

        }

        .table tbody td {
            text-align: right;
            /* Align text to the right inside tbody cells */
        }

        .table tbody .text {
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .table tbody .info {
            font-size: 14px;
            color: #772D2F;
            font-weight: bold;
        }

        .table tbody tr {
            padding-top: 5px;
            /* Adjust the top padding */
            padding-bottom: 5px;
            /* Adjust the bottom padding */
        }

        .table tfoot tr {
            text-align: right;
            /* Align text to the right inside tbody cells */
            padding-top: 5px;
            /* Adjust the top padding */
            padding-bottom: 5px;
            /* Adjust the bottom padding */
        }

        .bg-orange {
            background-color: #DE410F;
            color: white;
        }

        .table tfoot {
            border: none;
            /* Remove border for all but the last row in the tfoot */
        }

        .notes {
            margin-top: 50px;
        }

        .notes .text {
            font-size: 16px;
            color: #772D2F;
        }

        .textx {
            margin-top: -25px;
            width: 480px;
            /* Atur jarak kanan */
        }

        .textx h5 {
            margin-bottom: 5px;
            /* Atur jarak bawah h5 */
            font-weight: 700;
            font-size: 15px;
        }

        .textx h6 {
            margin-top: 5px;
            margin-bottom: 5px;
            /* Atur jarak bawah h5 */
            font-weight: 700;
            font-size: 12px;
        }

        .textx p {
            margin-top: 5px;
            /* Atur jarak atas p */
            font-size: 12px;
            font-weight: 400;
            color: #2B2C2E;
        }

        .ttd-text h5 {
            font-size: 14px;
            text-decoration: underline;
        }

        .ttd-text p {
            font-size: 12px;
            margin-top: -15px;
        }

        .ttd-text {
            text-align: center;
        }

        .line hr {
            border: none;
            /* Remove the default border */
            background-color: #DE410F;
            /* Set the background color to blue */
            height: 4px;
            /* Increase the height of the line */
            margin-top: 30px;
            margin-bottom: 50px;
        }

        .lampiranInf {
            margin-top: 30px;
            display: flex;
            justify-content: end;
        }

        .tbLampiran td {
            text-align: end;
            /* Align text to the end (right side) */
        }

        .tableInfoDetail {
            margin-top: 30px;
        }

        .tbInfo {
            width: 100%;
            border-collapse: collapse;
        }

        .tbInfo thead td {
            padding: 0.75rem;
            vertical-align: top;
            border: 3px solid white;
            /* Set border color of cells to white and increase width */
        }

        .tbInfo tbody td {
            padding: 0.3rem;
            padding-right: 8px;
            vertical-align: top;
            border: 3px solid white;
            /* Set border color of cells to white and increase width */
        }

        .tbLampiran tbody td {
            padding: 0.1rem;
            padding-right: 8px;
            vertical-align: top;
            border: 3px solid white;
            /* Set border color of cells to white and increase width */
        }

        .tbInfo tfoot td {
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 8px;
            vertical-align: top;
        }

        .tbInfo thead td {
            text-align: center;
            /* Center align the text in the <thead> */
            vertical-align: bottom;
            border-bottom: 3px solid white;
            /* Set header bottom border color to white and increase width */
        }

        .tbInfo tbody td {

            vertical-align: bottom;
            border-bottom: 3px solid white;
            /* Set header bottom border color to white and increase width */
            line-height: 1.5;
        }

        .tbInfo tbody+tbody {
            border-top: 3px solid white;
            /* Set border between tbInfo body sections to white and increase width */

        }

        .tbInfo thead {
            background-color: rgba(222, 65, 15, 0.2);
            /* Set opacity here */
        }

        .tbInfo thead .text {
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .tbInfo thead .info {
            font-size: 14px;
            color: #772D2F;
            font-weight: bold;

        }

        .tbInfo .description {
            width: 55%;
        }

        .text-end {
            text-align: end;
        }

        .text-warning {
            color: #772D2F;
        }

        .tbInfo tfoot td {
            text-align: end;
        }

        .total-label,
        .total-value {
            color: white;
            /* Change the color to whatever you desire */
        }

        .bg-warning {
            background-color: #DE410F;
            /* Adjust background color for emphasis */
        }

        .terbilang {
            border: 2px solid #000;
            /* Border style, adjust color and thickness as needed */
            padding: 15px;
            /* Padding to add space around text */
            width: 60%;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="invoice">

        <div class="header">
            <img src="{{ asset('/logo.png') }}" alt="">
            <h1>INVOICE</h1>
        </div>
        <div style="display: flex; justify-content: space-between">
            <div class="companyInfo">
                <h5>QNP CONSULTING</h5>
                <p>Graha Binakarsa, Mezzanine Floor Jl.H.R. Rasuna Said Kav. C18 Karet Kuningan, Setiabudi, Jakarta
                    Selatan
                </p>
            </div>
            <div class="companySocial">
                <div class="companyMail">
                    <span class="circle"><i class="far fa-envelope "></i></span>
                    qnp.consuting@gmail.com
                </div>
                <div class="companyMail">
                    <span class="circle"> <i class="fas fa-phone" style="transform: rotate(90deg);"></i></span>
                    081315175769
                </div>
                <div class="companyMail">
                    <span class="circle"> <i class="fas fa-globe"></i></span>
                    qnpconsulting.com
                </div>
            </div>
        </div>
        <div class="desc">
            <div class="invoiceTo">
                <h5 class="invText">INVOICE TO</h5>
                <div class="invx">
                    <h5>PT. SEMESTA ALAM BARITO</h5>
                    <h6>Mrs. Imelda Adhi Saputra</h6>
                    <h6>Direktur Utama</h6>
                    <p>
                        Jalan Sultan Agung Blok C-D No.63
                        Setiabudi, Jakarta Selatan
                        12970
                    </p>
                </div>
            </div>
            <div class="description">
                <h5 class="invText">Description</h5>
                <div class="invx">
                    <p>
                        Tax service: Agreement of Retainer Tax Advisory Services for the Tax Period January 2024 - March
                        2024
                        Kontrak No. EL-002/QNPIII/2024
                    </p>
                </div>
            </div>
        </div>

        <div class="tableInfo">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <span class="text"> <i class="fas fa-dollar-sign"></i> Total Due</span> <br>
                            <span class="info"> 1.123.899.000</span>
                        </th>
                        <th>
                            <span class="text"> <i class="far fa-calendar-alt"></i> Invoice Date</span> <br>
                            <span class="info"> 23 Apr 2024</span>
                        </th>
                        <th>
                            <span class="text"> <i class="fas fa-barcode"></i> Invoice #</span> <br>
                            <span class="info"> 24102/QNP-ACC/IV/2024</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td>
                            <span class="text"> Amount </span> <br>
                            <span class="info">1.031.100.000</span>
                        </td>
                        <td>
                            <span class="text">Total (Rp) </span><br>
                            <span class="info"> 1.031.100.000</span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <span class="text">SUB TOTAL : </span>
                        </td>
                        <td>
                            <span class="info"> 1.031.100.000</span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <span class="text">VAT 11% :</span>
                        </td>
                        <td>
                            <span class="info"> 1.031.100.000</span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <span class="text">Art 23 Income Tax 2% :</span>
                        </td>
                        <td>
                            <span class="info"> 1.031.100.000</span>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-orange">
                        <td></td>
                        <td>
                            <span class="text">Total Due :</span>
                        </td>
                        <td>
                            <span class="info"> 1.031.100.000</span>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
        <div class="notes">
            <div class="invoiceTo">
                <h5 class="text">Note</h5>
                <div class="textx">
                    <h5>Complete The Payment Transaction Via :</h5>

                    <p>
                        Account Name : Persekutuan Purbaya, Hartono, Hutapea & Rekan <br>
                        Bank Name : BCA KCP PLAZA INDEX <br>
                        No Rek : 7340777811
                    </p>
                    <h5>Terms: Payment due date 10 (Ten) days</h5>
                </div>
            </div>
        </div>

        <div class="ttd" style="margin-top: 100px; display: flex; justify-content: end">
            <div class="ttd-text">
                <h5>Wawan Setiyo Hartono </h5>
                <p>
                    Managing Director
                </p>
            </div>
        </div>
        <div class="line">
            <hr>
        </div>
    </div>
    <div class="invoice">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="">
            {{-- <h1>INVOICE</h1> --}}
        </div>
        <div style="display: flex; justify-content: space-between">
            <div class="companyInfo">
                <h5>QNP CONSULTING</h5>
                <p>Graha Binakarsa, Mezzanine Floor Jl.H.R. Rasuna Said Kav. C18 Karet Kuningan, Setiabudi, Jakarta
                    Selatan
                </p>
            </div>
            <div class="companySocial">
                <div class="companyMail">
                    <span class="circle"><i class="far fa-envelope "></i></span>
                    qnp.consuting@gmail.com
                </div>
                <div class="companyMail">
                    <span class="circle"> <i class="fas fa-phone" style="transform: rotate(90deg);"></i></span>
                    081315175769
                </div>
                <div class="companyMail">
                    <span class="circle"> <i class="fas fa-globe"></i></span>
                    qnpconsulting.com
                </div>
            </div>
        </div>
        <div class="lampiranInf">
            <table class="tbLampiran">
                <tbody>
                    <tr>
                        <td>Lampiran Invoice No :</td>
                        <td>24101/QNP-ACC/IV/2024</td>
                    </tr>
                    <tr>
                        <td>Date :</td>
                        <td>23-Apr-24</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tableInfoDetail">
            <table class="tbInfo">
                <thead>
                    <tr>
                        <td colspan="4" class="description">Description</td>
                        <td colspan="2">Amount</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">TAX Services : Tax audit Assistance of Corporate Income Tax for the Fical
                            Year 2019</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>PPh Pasal 26</td>
                        <td>10%</td>
                        <td>23.775.955.165</td>
                        <td class="text-end text-warning" colspan="2">2.377.595.517</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>PPh Pasal 26</td>
                        <td>10%</td>
                        <td>23.775.955.165</td>
                        <td class="text-end text-warning" colspan="2">2.377.595.517</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>PPh Pasal 26</td>
                        <td>10%</td>
                        <td>23.775.955.165</td>
                        <td class="text-end text-warning" colspan="2">2.377.595.517</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td class="bg-warning total-label">TOTAL :</td>
                        <td class="bg-warning total-value">3.395.965.217</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="terbilang">
            Tiga Milyar Tiga Ratus Sembilan Puluh Lima Juta Sembilan Ratus Enam Puluh Lima Ribu Dua Ratus Tujuh Belas
            Rupiah
        </div>
    </div>
</body>

</html>
