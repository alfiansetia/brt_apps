<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
    <meta name="author" content="spvmysrbakti" />
    <meta name="company" content="Microsoft Corporation" />
    <style type="text/css">
        html {
            font-family: Calibri, Arial, Helvetica, sans-serif;
            font-size: 11pt;
            background-color: white
        }

        a.comment-indicator:hover+div.comment {
            background: #ffd;
            position: absolute;
            display: block;
            border: 1px solid black;
            padding: 0.5em
        }

        a.comment-indicator {
            background: red;
            display: inline-block;
            border: 1px solid black;
            width: 0.5em;
            height: 0.5em
        }

        div.comment {
            display: none
        }

        table {
            border-collapse: collapse;
            page-break-after: always
        }

        .gridlines td {
            border: 1px dotted black
        }

        .gridlines th {
            border: 1px dotted black
        }

        .b {
            text-align: center
        }

        .e {
            text-align: center
        }

        .f {
            text-align: right
        }

        .inlineStr {
            text-align: left
        }

        .n {
            text-align: right
        }

        .s {
            text-align: left
        }

        td.style0 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style0 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style1 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style1 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style2 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style2 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style3 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style3 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style4 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style4 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style5 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style5 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style6 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style6 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style7 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style7 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style8 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style8 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style9 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style9 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style10 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style10 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style11 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style11 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style12 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style12 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style13 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style13 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style14 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style14 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style15 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style15 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style16 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style16 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style17 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style17 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style18 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style18 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style19 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style19 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style20 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style20 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style21 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style21 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style22 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style22 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style23 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style23 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style24 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style24 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style25 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style25 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style26 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style26 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style27 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style27 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style28 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style28 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style29 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        th.style29 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        td.style30 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        th.style30 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        td.style31 {
            vertical-align: middle;
            text-align: center;
            /* border-bottom: none #000000; */
            border-bottom: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        th.style31 {
            vertical-align: middle;
            text-align: center;
            /* border-bottom: none #000000; */
            border-bottom: 2px solid #000000 !important;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        td.style32 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        th.style32 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: 2px solid #000000 !important;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        td.style33 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        th.style33 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        td.style34 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        th.style34 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 2px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 2px solid #000000 !important;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #00B0F0
        }

        td.style35 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #FFFF00
        }

        th.style35 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 28pt;
            background-color: #FFFF00
        }

        td.style36 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style36 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        td.style37 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        th.style37 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: 2px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            font-weight: bold;
            color: #000000;
            font-family: 'Calibri';
            font-size: 11pt;
            background-color: white
        }

        table.sheet0 col.col0 {
            width: 42pt
        }

        table.sheet0 col.col1 {
            width: 42pt
        }

        table.sheet0 col.col2 {
            width: 42pt
        }

        table.sheet0 col.col3 {
            width: 42pt
        }

        table.sheet0 col.col4 {
            width: 42pt
        }

        table.sheet0 col.col5 {
            width: 42pt
        }

        table.sheet0 col.col6 {
            width: 42pt
        }

        table.sheet0 col.col7 {
            width: 42pt
        }

        table.sheet0 col.col8 {
            width: 42pt
        }

        table.sheet0 col.col9 {
            width: 42pt
        }

        table.sheet0 col.col10 {
            width: 42pt
        }

        table.sheet0 col.col11 {
            width: 42pt
        }

        table.sheet0 col.col12 {
            width: 42pt
        }

        table.sheet0 col.col13 {
            width: 42pt
        }

        table.sheet0 col.col14 {
            width: 42pt
        }

        table.sheet0 col.col15 {
            width: 42pt
        }

        table.sheet0 col.col16 {
            width: 42pt
        }

        table.sheet0 col.col17 {
            width: 42pt
        }

        table.sheet0 col.col18 {
            width: 52.86666606pt
        }

        table.sheet0 col.col19 {
            width: 42pt
        }

        table.sheet0 col.col20 {
            width: 42pt
        }

        table.sheet0 col.col21 {
            width: 42pt
        }

        table.sheet0 col.col22 {
            width: 42pt
        }

        table.sheet0 col.col23 {
            width: 42pt
        }

        table.sheet0 col.col24 {
            width: 42pt
        }

        table.sheet0 tr {
            height: 15pt
        }

        table.sheet0 tr.row1 {
            height: 15.75pt
        }

        table.sheet0 tr.row5 {
            height: 15.75pt
        }

        table.sheet0 tr.row15 {
            height: 15.75pt
        }

        table.sheet0 tr.row16 {
            height: 15.75pt
        }

        table.sheet0 tr.row18 {
            height: 15.75pt
        }

        table.sheet0 tr.row28 {
            height: 15.75pt
        }

        table.sheet0 tr.row29 {
            height: 15.75pt
        }

        table.sheet0 tr.row31 {
            height: 15.75pt
        }

        table.sheet0 tr.row41 {
            height: 15.75pt
        }

        table.sheet0 tr.row42 {
            height: 15.75pt
        }

        table.sheet0 tr.row44 {
            height: 15.75pt
        }

        table.sheet0 tr.row54 {
            height: 15.75pt
        }

        table.sheet0 tr.row55 {
            height: 15.75pt
        }

        table.sheet0 tr.row56 {
            height: 15.75pt
        }

        table.sheet0 tr.row65 {
            height: 15.75pt
        }
    </style>
</head>

<body>
    <style>
        @page {
            margin-left: 0.30902777777778in;
            margin-right: 0in;
            margin-top: 0.01875in;
            margin-bottom: 0.038888888888889in;
        }

        body {
            margin-left: 0.30902777777778in;
            margin-right: 0in;
            margin-top: 0.01875in;
            margin-bottom: 0.038888888888889in;
        }
    </style>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <col class="col11">
        <col class="col12">
        <col class="col13">
        <col class="col14">
        <col class="col15">
        <col class="col16">
        <col class="col17">
        <col class="col18">
        <col class="col19">
        <col class="col20">
        <col class="col21">
        <col class="col22">
        <col class="col23">
        <col class="col24">
        <tbody>
            <tr class="row0">
                <td class="column0 style29 s style31" colspan="25">DOKUMENTASI KEGIATAN PERAWATAN PT MAYASARI BAKTI
                </td>
            </tr>
            <tr class="row2">
                <td class="column0 style1 null"></td>
                <td class="column1 style36 s style36" colspan="2">TANGGAL</td>
                <td class="column3 style37 s style37" colspan="7">: {{ $data->date }} </td>
                <td class="column10 style35 s style35" colspan="5" rowspan="3">{{ $data->type }} INSPECTION</td>
                <td class="column15 style20 null style21" colspan="10"></td>
            </tr>
            <tr class="row3">
                <td class="column0 style1 null"></td>
                <td class="column1 style12 s style12" colspan="2">KODE UNIT</td>
                <td class="column3 style28 s style28" colspan="7">: {{ $data->unit->code }}</td>
                <td class="column15">&nbsp;</td>
                <td class="column16 style12 s style12" colspan="3">SERVICE TERAKHIR</td>
                <td class="column19 style12 s style14" colspan="6">: {{ $data->last_date }}</td>
            </tr>
            <tr class="row4">
                <td class="column0 style1 null"></td>
                <td class="column1 style12 s style12" colspan="2">KM UNIT</td>
                <td class="column3 style28 s style28" colspan="7">: {{ hrg($data->km) }} KM</td>
                <td class="column15">&nbsp;</td>
                <td class="column16 style12 s style12" colspan="3">KM SERVICE TERAKHIR</td>
                <td class="column19 style12 s style14" colspan="6">: {{ hrg($data->last_km) }} KM</td>
            </tr>
            <tr class="row5">
                <td class="column0 style4 null style6" colspan="25"></td>
            </tr>
            <tr class="row6">
                <td class="column0 style1 null"></td>
                <td class="column1 style22 null style24" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style22 null style24" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style22 null style24" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style22 null style24" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row7">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row8">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row9">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row10">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 s style15" colspan="5">N/A</td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 s style15" colspan="5">N/A</td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 s style15" colspan="5">N/A</td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 s style15" colspan="5">N/A</td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row11">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row12">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row13">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row14">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row15">
                <td class="column0 style1 null"></td>
                <td class="column1 style9 null style11" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style9 null style11" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style9 null style11" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style9 null style11" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row16">
                <td class="column0 style1 null"></td>
                <td class="column1 style25 s style27" colspan="5">LABEL</td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style25 s style27" colspan="5">LABEL</td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style25 s style27" colspan="5">LABEL</td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style25 s style27" colspan="5">LABEL</td>
                <td class="column24 style3 null"></td>
            </tr>
            {{-- <tr class="row17">
                <td class="column0 style4 null style6" colspan="25"></td>
            </tr>
            <tr class="row18">
                <td class="column0 style4 null style6" colspan="25"></td>
            </tr>
            <tr class="row19">
                <td class="column0 style1 null"></td>
                <td class="column1 style22 null style24" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style22 null style24" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style22 null style24" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style22 null style24" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row20">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row21">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row22">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row23">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 s style15" colspan="5">N/A</td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 s style15" colspan="5">N/A</td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 s style15" colspan="5">N/A</td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 s style15" colspan="5">N/A</td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row24">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row25">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row26">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row27">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row28">
                <td class="column0 style1 null"></td>
                <td class="column1 style9 null style11" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style9 null style11" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style9 null style11" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style9 null style11" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row29">
                <td class="column0 style1 null"></td>
                <td class="column1 style25 s style27" colspan="5">LABEL</td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style25 s style27" colspan="5">LABEL</td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style25 s style27" colspan="5">LABEL</td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style25 s style27" colspan="5">LABEL</td>
                <td class="column24 style3 null"></td>
            </tr> --}}
            {{-- <tr class="row30">
                <td class="column0 style4 null style6" colspan="25"></td>
            </tr>
            <tr class="row31">
                <td class="column0 style4 null style6" colspan="25"></td>
            </tr>
            <tr class="row32">
                <td class="column0 style1 null"></td>
                <td class="column1 style22 null style24" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style22 null style24" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style22 null style24" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style22 null style24" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row33">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row34">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row35">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row36">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 s style15" colspan="5">N/A</td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 s style15" colspan="5">N/A</td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 s style15" colspan="5">N/A</td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 s style15" colspan="5">N/A</td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row37">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row38">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row39">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row40">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row41">
                <td class="column0 style1 null"></td>
                <td class="column1 style9 null style11" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style9 null style11" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style9 null style11" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style9 null style11" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row42">
                <td class="column0 style1 null"></td>
                <td class="column1 style25 s style27" colspan="5">LABEL</td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style25 s style27" colspan="5">LABEL</td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style25 s style27" colspan="5">LABEL</td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style25 s style27" colspan="5">LABEL</td>
                <td class="column24 style3 null"></td>
            </tr> --}}
            {{-- <tr class="row43">
                <td class="column0 style4 null style6" colspan="25"></td>
            </tr>
            <tr class="row44">
                <td class="column0 style4 null style6" colspan="25"></td>
            </tr>
            <tr class="row45">
                <td class="column0 style1 null"></td>
                <td class="column1 style22 null style24" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style22 null style24" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style22 null style24" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style22 null style24" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row46">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row47">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row48">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row49">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 s style15" colspan="5">N/A</td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 s style15" colspan="5">N/A</td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 s style15" colspan="5">N/A</td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 s style15" colspan="5">N/A</td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row50">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row51">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row52">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row53">
                <td class="column0 style1 null"></td>
                <td class="column1 style7 null style15" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style7 null style15" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style7 null style15" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style7 null style15" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row54">
                <td class="column0 style1 null"></td>
                <td class="column1 style9 null style11" colspan="5"></td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style9 null style11" colspan="5"></td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style9 null style11" colspan="5"></td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style9 null style11" colspan="5"></td>
                <td class="column24 style3 null"></td>
            </tr>
            <tr class="row55">
                <td class="column0 style1 null"></td>
                <td class="column1 style25 s style27" colspan="5">LABEL</td>
                <td class="column6">&nbsp;</td>
                <td class="column7 style25 s style27" colspan="5">LABEL</td>
                <td class="column12">&nbsp;</td>
                <td class="column13 style25 s style27" colspan="5">LABEL</td>
                <td class="column18">&nbsp;</td>
                <td class="column19 style25 s style27" colspan="5">LABEL</td>
                <td class="column24 style3 null"></td>
            </tr> --}}
            <tr class="row56">
                <td class="column0 style16 null style18" colspan="25"></td>
            </tr>
            <tr class="row57">
                <td class="column0 style19 null style21" colspan="25"></td>
            </tr>
            <tr class="row58">
                <td class="column0 style7 null style8" colspan="2"></td>
                <td class="column2 style12 s style12" colspan="6">Dibuat Oleh</td>
                <td class="column8 style12 s style14" colspan="17">Diperiksa Oleh,</td>
            </tr>
            <tr class="row59">
                <td class="column0 style7 null style15" colspan="25"></td>
            </tr>
            <tr class="row60">
                <td class="column0 style7 null style15" colspan="25"></td>
            </tr>
            <tr class="row61">
                <td class="column0 style7 null style15" colspan="25"></td>
            </tr>
            <tr class="row62">
                <td class="column0 style7 null style15" colspan="25"></td>
            </tr>
            <tr class="row63">
                <td class="column0 style13 null style12" colspan="2"></td>
                <td class="column2 style12 s style12" colspan="6">Syamsudin</td>
                <td class="column8 style12 null style14" colspan="17"></td>
            </tr>
            <tr class="row64">
                <td class="column0 style7 null style8" colspan="2"></td>
                <td class="column2 style12 s style12" colspan="6">Supervisor PT United Tractors Tbk</td>
                <td class="column8 style12 s style14" colspan="17">Pengawas PT Mayasari Bakti</td>
            </tr>
            <tr class="row65">
                <td class="column0 style9 null style11" colspan="25"></td>
            </tr>
            <tr class="row66">
                <td class="column0">&nbsp;</td>
                <td class="column1">&nbsp;</td>
                <td class="column2 style2 null"></td>
                <td class="column3 style2 null"></td>
                <td class="column4 style2 null"></td>
                <td class="column5 style2 null"></td>
                <td class="column6 style2 null"></td>
                <td class="column7 style2 null"></td>
                <td class="column8 style2 null"></td>
                <td class="column9 style2 null"></td>
                <td class="column10 style2 null"></td>
                <td class="column11 style2 null"></td>
                <td class="column12 style2 null"></td>
                <td class="column13 style2 null"></td>
                <td class="column14 style2 null"></td>
                <td class="column15 style2 null"></td>
                <td class="column16">&nbsp;</td>
                <td class="column17">&nbsp;</td>
                <td class="column18">&nbsp;</td>
                <td class="column19">&nbsp;</td>
                <td class="column20">&nbsp;</td>
                <td class="column21">&nbsp;</td>
                <td class="column22">&nbsp;</td>
                <td class="column23">&nbsp;</td>
                <td class="column24">&nbsp;</td>
            </tr>
            <tr class="row67">
                <td class="column0">&nbsp;</td>
                <td class="column1">&nbsp;</td>
                <td class="column2 style2 null"></td>
                <td class="column3 style2 null"></td>
                <td class="column4 style2 null"></td>
                <td class="column5 style2 null"></td>
                <td class="column6 style2 null"></td>
                <td class="column7 style2 null"></td>
                <td class="column8 style2 null"></td>
                <td class="column9 style2 null"></td>
                <td class="column10 style2 null"></td>
                <td class="column11 style2 null"></td>
                <td class="column12 style2 null"></td>
                <td class="column13 style2 null"></td>
                <td class="column14 style2 null"></td>
                <td class="column15 style2 null"></td>
                <td class="column16">&nbsp;</td>
                <td class="column17">&nbsp;</td>
                <td class="column18">&nbsp;</td>
                <td class="column19">&nbsp;</td>
                <td class="column20">&nbsp;</td>
                <td class="column21">&nbsp;</td>
                <td class="column22">&nbsp;</td>
                <td class="column23">&nbsp;</td>
                <td class="column24">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
