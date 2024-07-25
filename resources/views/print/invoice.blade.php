<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }}</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/invoice.css') }}"> --}}
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
            width: 201mm;
            /* Sesuaikan dengan lebar kertas A4 */
            height: 280mm;
            margin: 20px auto;
            padding: 40px;
            /* border: 1px solid #ccc; */
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
            width: 245px;
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
            font-size: 14px;
            font-weight: 400;
            color: #2B2C2E;
        }

        .circle {
            display: inline-block;
            width: 25px;
            /* Adjust the size of the circle */
            height: 25px;
            /* Adjust the size of the circle */
            background-color: rgba(222, 65, 15, 0.2) !important;
            print-color-adjust: exact;
            /* Set opacity here */
            border-radius: 50%;
            /* Makes it a circle */
            text-align: center;
            line-height: 25px;
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
            font-size: 14px;
            margin-left: 5px;
            margin-right: 5px;
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
            font-size: 14px;
        }

        .invx p {
            margin-top: 5px;
            /* Atur jarak atas p */
            font-size: 14px;
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
            background-color: rgba(222, 65, 15, 0.2) !important;
            print-color-adjust: exact;
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
            background-color: #DE410F !important;
            color: white;
            print-color-adjust: exact;
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
            font-size: 14px;
        }

        .textx p {
            margin-top: 5px;
            /* Atur jarak atas p */
            font-size: 14px;
            font-weight: 400;
            color: #2B2C2E;
        }

        .ttd-text h5 {
            font-size: 14px;
            text-decoration: underline;
        }

        .ttd-text p {
            font-size: 14px;
            margin-top: -15px;
        }

        .ttd-text {
            text-align: center;
        }

        .line hr {
            border: none;
            /* Remove the default border */
            background-color: #DE410F !important;
            print-color-adjust: exact;
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

        .tbLampiran tbody td {
            padding: 0.1rem;
            padding-right: 8px;
            vertical-align: top;
            border: 3px solid white;
            /* Set border color of cells to white and increase width */
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
            background-color: rgba(222, 65, 15, 0.2) !important;
            print-color-adjust: exact;
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


        .tbInfo tfoot td {
            text-align: end;
        }

        .total-label,
        .total-value {
            color: white;
            /* Change the color to whatever you desire */
        }

        .text-end {
            text-align: end;
        }

        .text-warning {
            color: #772D2F;
        }

        .bg-warning {
            background-color: #DE410F !important;
            print-color-adjust: exact;
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

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            @page {
                margin-top: 0;
                margin-bottom: 0;
            }

            body {
                padding-top: 72px;
                padding-bottom: 72px;
            }
        }
    </style>
    <style>
        .btn-primary {
            background-color: #007bff;
            /* Warna latar belakang */
            color: #fff;
            /* Warna teks */
            border: none;
            /* Hapus garis tepi */
            padding: 10px 20px;
            /* Padding */
            border-radius: 5px;
            /* Tambahkan sudut bulat */
            cursor: pointer;
            /* Ubah kursor saat mengarah ke tombol */
            font-size: 16px;
            /* Ukuran teks */
            font-weight: bold;
            /* Ketebalan teks */
            text-transform: uppercase;
            /* Ubah teks menjadi huruf kapital */
            transition: background-color 0.3s ease;
            /* Animasi perubahan warna latar belakang */
        }

        /* Hover state */
        .btn-primary:hover {
            background-color: #0056b3;
            /* Ubah warna latar belakang saat dihover */
        }

        .header img {
            display: block;
            /* Ensure that the image is displayed */
        }
    </style>
    <style>
        .tbList {
            width: 100%;
            border-collapse: collapse;
        }

        .tbList thead td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid white;
            /* Set border color of cells to white and increase width */
        }

        .tbList tbody td {
            padding: 0.3rem;
            padding-right: 8px;
            vertical-align: top;
            border: 3px solid white;
            /* Set border color of cells to white and increase width */
        }

        .tbList tfoot td {
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 8px;
            vertical-align: top;
            font-size: 14px;
        }

        .tbList thead td {
            /* text-align: center; */
            font-size: 15px;
            /* Center align the text in the <thead> */
            vertical-align: bottom;
            border-bottom: 1px solid white;
            /* Set header bottom border color to white and increase width */
        }

        .tbList tbody td {
            border-bottom: px solid white;
            line-height: 1.5;
            font-size: 13px;
            text-align: justify
        }

        .tbList tbody+tbody {
            border-top: 3px solid white;
            /* Set border between tbList body sections to white and increase width */

        }

        .tbList thead {
            background-color: rgba(222, 65, 15, 0.2) !important;
            print-color-adjust: exact;
            /* Set opacity here */
        }

        .tbList thead .text {
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .tbList thead .info {
            font-size: 14px;
            color: #772D2F;
            font-weight: bold;

        }

        .tbList .description {
            width: 55%;
        }


        .tbList tfoot td {
            text-align: end;
        }
    </style>
</head>

<body>
    <div style="width: 201mm; margin: 20px auto" id="buttonView">
        <div style="display: flex; justify-content: end; margin-top: 2px;   ">
            <button class="btn-primary" onclick="printContent()">
                <i class="fas fa-print"></i>
                Print
            </button>
        </div>
    </div>
    <div class="print" id="print">
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
                        qnp.consulting@gmail.com
                    </div>
                    <div class="companyMail">
                        <span class="circle"> <i class="fas fa-phone" style="transform: rotate(90deg);"></i></span>
                        +6281315175769
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
                        <h5>{{ $trx->getClient->company_name ?? '-' }}</h5>
                        <h6>{{ $trx->getClient->name ?? '-' }}</h6>
                        <h6>{{ $trx->getClient->position ?? '-' }}</h6>
                        <p>
                            {{ $trx->getClient->company_address ?? '-' }}
                        </p>
                    </div>
                </div>
                <div class="description">
                    <h5 class="invText">Description</h5>
                    <div class="invx">
                        <p class="text-end">
                            {{ $trx->desc }}
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
                                <span class="info">{{ num($trx->due_total) }}</span>
                            </th>
                            <th>
                                <span class="text"> <i class="far fa-calendar-alt"></i> Invoice Date</span> <br>
                                <span class="info"> {{ df($trx->created_at) }}</span>
                            </th>
                            <th>
                                <span class="text"> <i class="fas fa-barcode"></i> Invoice #</span> <br>
                                <span class="info"> {{ $trx->trx }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>
                                <span class="text"> Amount </span> <br>
                                <span class="info">{{ num($trx->sub_total) }}</span>
                            </td>
                            <td>
                                <span class="text">Total (Rp) </span><br>
                                <span class="info">{{ num($trx->sub_total) }}</span>
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
                                <span class="info">{{ num($trx->sub_total) }}</span>
                            </td>
                        </tr>
                        @foreach ($trx->getAdditional as $item)
                            <tr>
                                <td></td>
                                <td>
                                    <span class="text">{{ $item->name }} {{ $item->percent }}%</span>
                                </td>
                                <td>
                                    <span class="info">
                                        {{ num($item->total) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-orange">
                            <td></td>
                            <td>
                                <span class="text">Total Due :</span>
                            </td>
                            <td>
                                <span class="info">{{ num($trx->due_total) }}</span>
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
                        <table>
                            <tr>
                                <td>Account Name</td>
                                <td>:</td>
                                <td>Persekutuan Purbaya, Hartono, Hutapea & Rekan</td>
                            </tr>
                            <tr>
                                <td>Bank Name</td>
                                <td>:</td>
                                <td>BCA KCP PLAZA INDEX</td>
                            </tr>
                            <tr>
                                <td>No Rek</td>
                                <td>:</td>
                                <td>7340777811</td>
                            </tr>
                        </table>
                        <h5>Terms: Payment due date 10 (Ten) days</h5>
                    </div>
                </div>
            </div>

            <div class="ttd" style="margin-top: 100px; display: flex; justify-content: end">
                <div class="ttd-text">
                    <h5>Wawan Setiyo Hartono </h5>
                    <p>
                        Managing Partner
                    </p>
                </div>
            </div>
            <div class="line">
                <hr>
            </div>
        </div>
        @if ($trx->type == 1)
            <div class="invoice">
                <div class="header" style="margin-top: 80px">
                    <img src="{{ asset('logo.png') }}" alt="">

                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                    <div class="companyInfo">
                        <h5>QNP CONSULTING</h5>
                        <p>Graha Binakarsa, Mezzanine Floor Jl.H.R. Rasuna Said Kav. C18 Karet Kuningan, Setiabudi,
                            Jakarta
                            Selatan
                        </p>
                    </div>
                    <div class="companySocial">
                        <div class="companyMail">
                            <span class="circle"><i class="far fa-envelope "></i></span>
                            qnp.consulting@gmail.com
                        </div>
                        <div class="companyMail">
                            <span class="circle"> <i class="fas fa-phone" style="transform: rotate(90deg);"></i></span>
                            +6281315175769
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
                                <td>Invoice No :</td>
                                <td>{{ $trx->trx }}</td>
                            </tr>
                            <tr>
                                <td>Date :</td>
                                <td>{{ df($trx->created_at) }}</td>
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
                                <td colspan="4">{{ $trx->desc }}</td>
                                <td colspan="2"></td>
                            </tr>
                            @foreach ($trx->getDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->getProduct->name }}</td>
                                    <td>{{ $item->getProduct->percent }}%</td>
                                    <td>{{ num($item->price) }}</td>
                                    <td class="text-end text-warning" colspan="2">{{ num($item->amount) }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td class="bg-warning total-label">TOTAL :</td>
                                <td class="bg-warning total-value">{{ num($trx->total) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="terbilang">
                    {{ terbilang($trx->total) }} Rupiah
                </div>
            </div>
        @else
            <div class="invoice">
                <div class="header" style="margin-top: 50px">
                    <img src="{{ asset('logo.png') }}" alt="">

                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                    <div class="companyInfo">
                        <h5>QNP CONSULTING</h5>
                        <p>Graha Binakarsa, Mezzanine Floor Jl.H.R. Rasuna Said Kav. C18 Karet Kuningan, Setiabudi,
                            Jakarta
                            Selatan
                        </p>
                    </div>
                    <div class="companySocial">
                        <div class="companyMail">
                            <span class="circle"><i class="far fa-envelope "></i></span>
                            qnp.consulting@gmail.com
                        </div>
                        <div class="companyMail">
                            <span class="circle"> <i class="fas fa-phone"
                                    style="transform: rotate(90deg);"></i></span>
                            +6281315175769
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
                                <td>{{ $trx->trx }}</td>
                            </tr>
                            <tr>
                                <td>Date :</td>
                                <td>{{ df($trx->created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tableInfoDetail">
                    <table class="tbList">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Start</td>
                                <td>End</td>
                                <td>Who</td>
                                <td>Description</td>
                                <td>Cost</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trx->getDetailList as $item)
                                <tr>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->start }}</td>
                                    <td>{{ $item->end }}</td>
                                    <td>{{ $item->who }}</td>
                                    <td style="width: 40%">{{ $item->description }}</td>
                                    <td>{{ num($item->cost) }}</td>
                                </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td class="bg-warning total-label">TOTAL :</td>
                                <td class="bg-warning total-value">{{ num($trx->total) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        @endif

    </div>
    <script>
        function printContent() {
            // Hide the button when printing
            var button = document.getElementById('buttonView');
            button.style.display = 'none';

            // Print the content
            window.print();

            // Show the button again after printing
            button.style.display = '';
            // };
        }
    </script>
</body>

</html>
