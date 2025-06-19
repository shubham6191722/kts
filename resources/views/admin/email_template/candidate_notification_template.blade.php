<!DOCTYPE html>
<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
    <head>
        <title></title>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css"/>
        <style>
            * {
                box-sizing: border-box;
                font-style:normal !important;
            }

            th.column {
                padding: 0
            }

            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: inherit !important;
            }

            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
            }

            p {
                line-height: inherit
            }

            @media (max-width:620px) {
                .icons-inner {
                    text-align: center;
                }

                .icons-inner td {
                    margin: 0 auto;
                }

                .row-content {
                    width: 100% !important;
                }

                .image_block img.big {
                    width: auto !important;
                }

                .stack .column {
                    width: 100%;
                    display: block;
                }
            }
            .themecolor1{
                color:#000;
            }
            .themecolor1_bg{
                background-color:#000;
            }
            /*TOPIC*/
            .topic{
                width: 100%;
                display: block;
                float: left;
                border-bottom: 1px solid rgba(0,0,0,.1);
                padding: 1.5em 0 1.5em 0;
            }
            .topic .img{
                width: 120px;
                float: left;
            }
            .topic .text{
                width: calc(100%);
                padding-left: 20px;
                float: left;
            }
            .topic .text h3{
                font-size: 20px;
                margin-bottom: 15px;
                line-height: 1.2;
            }
            .topic .text .meta{
                margin-bottom: 10px;
            }
            /*BUTTON*/
            .btn{
                padding: 5px 20px;
                display: inline-block;
            }
            .btn.btn-primary{
                border-radius: 5px;
                background: #000000;
                color: #ffffff;
                text-decoration: none;
            }
            .btn.btn-white{
                border-radius: 5px;
                background: #ffffff;
                color: #000000;
            }
            .btn.btn-white-outline{
                border-radius: 5px;
                background: transparent;
                border: 1px solid #fff;
                color: #fff;
            }
            .btn.btn-black{
                border-radius: 0px;
                background: #000;
                color: #fff;
            }
            .btn.btn-black-outline{
                border-radius: 0px;
                background: transparent;
                border: 2px solid #000;
                color: #000;
                font-weight: 700;
            }
            .btn.btn-custom{
                text-transform: uppercase;
                font-weight: 600;
                font-size: 12px;
            }
            .company_main{
                display:block;
            }
        </style>
    </head>
    <body style="background-color: #ffffff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
        <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;padding-top: 32px;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;background-color: #FFF;border: 1px solid #e2e2e2;" width="600">
                                            <tbody>
                                                <tr>
                                                    <th class="column" style="mso-table-lspace: 0; mso-table-rspace: 0; font-weight: 400; text-align: left; vertical-align: top;" width="100%">
                                                        <table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;" width="100%">
                                                            <tr>
                                                                <td style="padding: 25px 25px 0 25px;" >
                                                                    <div style="font-family: sans-serif">
                                                                        <div style="font-size: 14px; color: #000; line-height: 1.2; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;">

                                                                            @php
                                                                                $description = \App\CustomFunction\CustomFunction::decode_input($description);
                                                                            @endphp
                                                                            {!! $description !!}
                                                                            

                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;" width="100%">
                                                            <tr>
                                                                <td style="padding: 0 25px;" >
                                                                    <div style="font-family: sans-serif">
                                                                        <div style="font-size: 14px; color: #000; line-height: 1.2; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;">

                                                                            @php
                                                                                $emailDescription = \App\CustomFunction\CustomFunction::decode_input($emailDescription);
                                                                            @endphp

                                                                            {!! $emailDescription !!}

                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;padding-bottom: 32px;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;background-color: #ffffff;padding-bottom: 10px;" width="600">
                                            <tbody>
                                                <tr>
                                                    <th class="column" style="mso-table-lspace: 0; mso-table-rspace: 0; font-weight: 400; text-align: left; vertical-align: top;" width="100%">
                                                        <table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;background-color: #f2f2f2;" width="100%">
                                                            <tr>
                                                                <td style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:10px;width:100%;background-color: #f2f2f2;">
                                                                    <div align="center" style="line-height:10px">
                                                                        <a href="javascript:;" style="outline:none" tabindex="-1">
                                                                            <img alt="Logo" src="{!!$siteHeaderLogo!!}" style="display: block;height: auto;border: 0;width: 50px;max-width: 100%;" title="Logo" width="100"/>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;" width="100%">
                                                            <tr>
                                                                <td style="padding-bottom:0px;padding-left:10px;padding-right:10px;padding-top:10px;">
                                                                    <div style="font-family: sans-serif">
                                                                        <div style="font-size: 14px; color: #000; line-height: 1.2; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;">
                                                                            <p style="margin: 0; text-align: center; font-size: 12px;"><span style="font-size:12px;color: #000000;">Copyright &copy; {!!date('Y')!!} {!!$siteTitle!!}.</span></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
