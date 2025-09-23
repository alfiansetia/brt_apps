<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REPLACE V BELT AC, VIBRATION INSULATOR 2 PCS, WATER PUMP</title>
    <style>
        body {
            font-family: 'calibri'
        }

        table {
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        @page {
            margin-left: 0.1in;
            margin-right: 0.1in;
            margin-top: 0.1in;
            margin-bottom: 0.1in;
            /* width: 11.69in; */
            /* height: 8.27in; */
        }

        body {
            margin-left: 0in;
            margin-right: 0in;
            margin-top: 0in;
            margin-bottom: 0in;
        }

        .left2 {
            border-left: 2px solid black;
        }

        .right2 {
            border-right: 2px solid black;
        }

        .top2 {
            border-top: 2px solid black;
        }

        .bottom2 {
            border-bottom: 2px solid black;
        }

        .left1 {
            border-left: 1px solid black;
        }

        .right1 {
            border-right: 1px solid black;
        }

        .top1 {
            border-top: 1px solid black;
        }

        .bottom1 {
            border-bottom: 1px solid black;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .f13 {
            font-size: 10pt;
        }

        .f15 {
            font-size: 15pt;
        }

        .f17 {
            font-size: 17pt;
        }

        .f20 {
            font-size: 20pt;
        }

        .image {
            width: 120pt;
            height: 162pt;
        }
    </style>
</head>

<body onload="window.print()">
    <table style="width: 100%">
        <tbody>
            <tr>
                <td colspan="12" class="left2 top2 right2 bottom1 center f15 bold">
                    REPLACE V BELT AC, VIBRATION INSULATOR 2 PCS, WATER PUMP
                </td>
            </tr>
            <tr>
                <td colspan="12"></td>
            </tr>
            <tr style="width: 50%">
                <td class="left2 top1 bold f13" style="white-space: nowrap;">Unit</td>
                <td class="top1 bold f13" colspan="5">: {{ $data->unit_detail }}</td>
                <td class="top1 bold f13" style="white-space: nowrap;">Start Date</td>
                <td class="right2 top1 bold f13" colspan="5">: {{ $data->startDateIndo }}</td>
            </tr>
            <tr style="width: 50%">
                <td class="left2 bold f13" style="white-space: nowrap;">Serial Number</td>
                <td class="bold f13" colspan="5">: {{ $data->sn }}</td>
                <td class="bold f13" style="white-space: nowrap;">Finish Date</td>
                <td class="right2 bold f13" colspan="5">: {{ $data->finishDateIndo }}</td>
            </tr>
            <tr style="width: 50%">
                <td class="bottom1 left2 bold f13" style="white-space: nowrap;">Unit Code</td>
                <td class="bottom1 bold f13" colspan="5">: {{ $data->unit->code }}</td>
                <td class="bottom1 bold f13" style="white-space: nowrap;">Hm / Km</td>
                <td class="bottom1 right2 bold f13" colspan="5">: {{ $data->hm }} / {{ $data->km }}</td>
            </tr>
            @foreach ($news as $row)
                <tr>
                    @foreach ($row as $index => $item)
                        @php
                            $first = false;
                            $last = false;
                            if ($index % 4 == 0) {
                                $first = true;
                            }
                            if ($index == 3) {
                                $last = true;
                            }
                        @endphp
                        <td class="{{ $first ? 'left2' : '' }} {{ $last ? 'right2' : '' }} center" colspan="3">
                            <img class="image" src="{{ $item->imagepath() }}" />
                        </td>
                    @endforeach
                    @for ($i = count($row); $i < 4; $i++)
                        <td class="{{ $i == 3 ? 'right2' : 'center' }} center" colspan="3">
                            {{-- kosong --}}
                        </td>
                    @endfor
                </tr>
            @endforeach

            <tr>
                <td class="left2 right2 top1 bottom1 bold center f20" colspan="12">
                    PART BARU
                </td>
            </tr>

            @foreach ($olds as $row)
                <tr>
                    @foreach ($row as $index => $item)
                        @php
                            $first = false;
                            $last = false;
                            if ($index % 4 == 0) {
                                $first = true;
                            }
                            if ($index == 3) {
                                $last = true;
                            }
                        @endphp
                        <td class="{{ $first ? 'left2' : '' }} {{ $last ? 'right2' : '' }} center" colspan="3">
                            <img class="image" src="{{ $item->imagepath() }}" />
                        </td>
                    @endforeach
                    @for ($i = count($row); $i < 4; $i++)
                        <td class="{{ $i == 3 ? 'right2' : 'center' }} center" colspan="3">
                            {{-- kosong --}}
                        </td>
                    @endfor
                </tr>
            @endforeach

            <tr>
                <td class="left2 right2 top1 bottom2 bold center f20" colspan="12">
                    PART BEKAS
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
