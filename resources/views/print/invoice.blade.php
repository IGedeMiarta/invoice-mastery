<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }}</title>
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
</head>

<body>
    <div class="invoice">


        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="">
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
