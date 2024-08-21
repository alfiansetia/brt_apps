<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <style>
        html {
            font-family: Helvetica, sans-serif;
            font-size: 8px;
            background-color: white
        }

        table {
            border-collapse: collapse;
            /* page-break-after: always */
        }

        @page {
            margin-left: 0.1in;
            margin-right: 0.1in;
            margin-top: 0.1in;
            margin-bottom: 0.1in;
            width: 11.69in;
            height: 8.27in;
        }

        body {
            margin-left: 0in;
            margin-right: 0in;
            margin-top: 0in;
            margin-bottom: 0in;
        }

        .initial {
            vertical-align: middle;
            color: #000000;
            font-size: 8px;
            background-color: white;
            height: 10px;
            width: 30px;
            /* width: 38pt; */
            /* //42 */
        }

        .left-border {
            border-left: 2px solid #000000 !important;
        }

        .right-border {
            border-right: 2px solid #000000 !important;
        }

        .top-border {
            border-top: 2px solid #000000 !important;
        }

        .bottom-border {
            border-bottom: 2px solid #000000 !important;
        }

        .all-border {
            border-left: 2px solid #000000 !important;
            border-right: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-bottom: 2px solid #000000 !important;
        }

        .all-border-one {
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-bottom: 1px solid #000000 !important;
        }

        .title {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-left: 2px solid #000000 !important;
            border-right: 2px solid #000000 !important;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 17px;
            background-color: #00B0F0
        }

        .type {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 17px;
            background-color: #FFFF00;
        }

        .bold {
            font-weight: bold;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0" style="width: 100%;">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <col class="initial">
        <tbody>
            <tr class="row">
                <td class="title" colspan="25">
                    DOKUMENTASI KEGIATAN PERAWATAN PT MAYASARI BAKTI
                </td>
            </tr>
            <tr class="row">
                <td class="initial left-border"></td>
                <td class="initial bold" colspan="2" style="padding-top: 3px">TANGGAL</td>
                <td class="initial bold" colspan="6">: {{ $data->date_parse() }} </td>
                <td class="type" colspan="5" rowspan="3">{{ $data->type }} INSPECTION</td>
                <td class="initial right-border" colspan="11"></td>
            </tr>
            <tr class="row">
                <td class="initial left-border"></td>
                <td class="initial bold" colspan="2" style="padding-top: 3px">KODE UNIT</td>
                <td class="initial bold" colspan="6">: {{ $data->unit->code }}</td>
                <td class="initial" colspan="2">&nbsp;</td>
                <td class="initial bold" colspan="3">SERVICE TERAKHIR</td>
                <td class="initial bold right-border" colspan="6">: {{ $data->last_date_parse() }}</td>
            </tr>
            <tr class="row">
                <td class="initial left-border"></td>
                <td class="initial bold" colspan="2" style="padding-top: 3px">KM UNIT</td>
                <td class="initial bold" colspan="6">: {{ hrg($data->km) }} KM</td>
                <td class="initial" colspan="2">&nbsp;</td>
                <td class="initial bold" colspan="3">KM SERVICE TERAKHIR</td>
                <td class="initial bold right-border" colspan="6">: {{ hrg($data->last_km) }} KM</td>
            </tr>
            <tr class="row">
                <td class="initial left-border right-border" colspan="25"></td>
            </tr>

            @forelse ($items as $chunk)
                <tr class="row">
                    <td class="initial left-border"></td>
                    @foreach ($chunk as $index => $item)
                        <td class="initial center all-border" colspan="5"
                            style="max-width: 250px; max-height: 117px;">
                            <img src="{{ $item->imagepath() }}"
                                style="max-width: 250px; max-height: 117px;width: 100%; height: 100%;" />
                        </td>
                        <td class="initial right-border">&nbsp;</td>
                    @endforeach

                    @for ($j = count($chunk); $j < 4; $j++)
                        <td class="initial center all-border" colspan="5">
                            N/A
                        </td>
                        <td class="initial right-border">&nbsp;</td>
                    @endfor
                </tr>

                <tr class="row">
                    <td class="initial left-border"></td>
                    @foreach ($chunk as $index => $item)
                        <td class="initial center left-border right-border bottom-border" colspan="5">
                            {{ $item->label }}
                        </td>
                        <td class="initial right-border">&nbsp;</td>
                    @endforeach

                    @for ($k = count($chunk); $k < 4; $k++)
                        <td class="initial center left-border right-border bottom-border" colspan="5">
                            (OPTIONAL)
                        </td>
                        <td class="initial right-border">&nbsp;</td>
                    @endfor
                </tr>

                <tr class="row">
                    <td class="initial left-border right-border" colspan="25"></td>
                </tr>

                @if ($loop->iteration % 4 == 0 && count($items) > 4)
                    <tr class="row">
                        <td class="initial left-border right-border bottom-border" colspan="25"></td>
                    </tr>
                    <tr class="row" style="page-break-before: always;">
                        <td class="initial" colspan="25"></td>
                    </tr>
                @endif
            @empty
                <tr class="row">
                    <td class="initial left-border right-border" colspan="25"></td>
                </tr>
                <tr class="row">
                    <td class="initial left-border"></td>
                    @for ($i = 0; $i < 4; $i++)
                        <td class="initial center all-border" colspan="5" style="width: 250px; height: 117px;">N/A
                        </td>
                        <td class="initial right-border">&nbsp;</td>
                    @endfor
                </tr>
                <tr class="row">
                    <td class="initial left-border"></td>
                    @for ($i = 0; $i < 4; $i++)
                        <td class="initial center left-border right-border bottom-border" colspan="5">(OPTIONAL)
                        </td>
                        <td class="initial right-border">&nbsp;</td>
                    @endfor
                </tr>
                <tr class="row">
                    <td class="initial left-border right-border" colspan="25"></td>
                </tr>
            @endforelse

            <tr class="row">
                <td class="initial left-border right-border" colspan="25"></td>
            </tr>
            <tr class="row">
                <td class="initial left-border right-border top-border" colspan="25"></td>
            </tr>
            <tr class="row">
                <td class="initial bold left-border" colspan="2"></td>
                <td class="initial bold" colspan="6">Dibuat Oleh</td>
                <td class="initial bold right-border" colspan="17">Diperiksa Oleh,</td>
            </tr>
            @for ($i = 0; $i < 5; $i++)
                <tr class="row">
                    <td class="initial left-border right-border" colspan="25"></td>
                </tr>
            @endfor
            <tr class="row">
                <td class="initial bold left-border" colspan="2"></td>
                <td class="initial bold" colspan="6">Syamsudin</td>
                <td class="initial bold right-border" colspan="17"></td>
            </tr>
            <tr class="row">
                <td class="initial bold left-border" colspan="2"></td>
                <td class="initial bold" colspan="6">Supervisor PT United Tractors Tbk</td>
                <td class="initial bold right-border" colspan="17">Pengawas PT Mayasari Bakti</td>
            </tr>
            <tr class="row">
                <td class="initial left-border bottom-border right-border" colspan="25"></td>
            </tr>

        </tbody>
    </table>
</body>

</html>
