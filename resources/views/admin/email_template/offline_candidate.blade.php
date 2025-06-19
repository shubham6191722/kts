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
                                                        @if((isset($company_logo) && !empty($company_logo)))
                                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;background-color: #f2f2f2;" width="100%">
                                                            <tr>
                                                                <td style="padding-bottom: 20px;padding-left:10px;padding-right:10px;padding-top:20px;width:100%;background-color: #f2f2f2;">
                                                                    <div align="center" style="line-height:10px">
                                                                        <a href="javascript:;" style="outline:none" tabindex="-1">
                                                                            <img alt="Logo" src="{!!$company_logo!!}" style="display: block;height: auto;border: 0;width: 200px;max-width: 100%;padding: 15px;" title="Logo" width="150"/>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        @endif
                                                        <table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;" width="100%">
                                                            <tr>
                                                                <td style="padding: 25px;" >
                                                                    <div style="font-family: sans-serif">
                                                                        @php
                                                                            $client_company_name = \App\CustomFunction\CustomFunction::decode_input($client_company_name);
                                                                            $job_name = \App\CustomFunction\CustomFunction::decode_input($job_name);
                                                                        @endphp
                                                                        @if(isset($client_company_name) && !empty($client_company_name))
                                                                            <div style="font-size: 16px; color: rgb(0,0,0,0.6); line-height: 1.2; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;font-weight: 600;padding-bottom: 10px;">
                                                                                Company: <span style="font-size: 16px;color: rgb(0,0,0,0.6);line-height: 1.2;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 300;padding-bottom: 10px;">{!! $client_company_name !!}</span>
                                                                            </div>
                                                                        @endif
                                                                        @if(isset($job_name) && !empty($job_name))
                                                                            <div style="font-size: 16px; color: rgb(0,0,0,0.6); line-height: 1.2; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;font-weight: 600;padding-bottom: 10px;">
                                                                                Job Title: <span style="font-size: 16px;color: rgb(0,0,0,0.6);line-height: 1.2;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 300;padding-bottom: 10px;">{!! $job_name !!}</span>
                                                                            </div>
                                                                        @endif
                                                                        @if(isset($candidate_name) && !empty($candidate_name))
                                                                        <div style="font-size: 16px; color: rgb(0,0,0,0.6); line-height: 1.2; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;font-weight: 600;padding-bottom: 10px;">

                                                                            @php
                                                                                $candidate_name = \App\CustomFunction\CustomFunction::decode_input($candidate_name);
                                                                            @endphp
                                                                            
                                                                            Candidate: <span style="font-size: 16px;color: rgb(0,0,0,0.6);line-height: 1.2;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 300;padding-bottom: 10px;">{!! $candidate_name !!}</span>
                                                                        </div>
                                                                        @endif
                                                                        
                                                                        @if(isset($recruiter_name) && !empty($recruiter_name))
                                                                        <div style="font-size: 16px; color: rgb(0,0,0,0.6); line-height: 1.2; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;font-weight: 600;padding-bottom: 10px;">

                                                                            @php
                                                                                $recruiter_name = \App\CustomFunction\CustomFunction::decode_input($recruiter_name);
                                                                            @endphp
                                                                            
                                                                            Recruiter: <span style="font-size: 16px;color: rgb(0,0,0,0.6);line-height: 1.2;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 300;padding-bottom: 10px;">{!! $recruiter_name !!}</span>
                                                                        </div>
                                                                        @endif

                                                                        <div style="font-size: 20px; color: #000; line-height: 1.2; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;font-weight: 600;padding-bottom: 10px;text-align: center;margin: 20px 0 10px 0;font-style:normal !important">
                                                                            {!! $new_message !!}
                                                                        </div>

                                                                        <div style="font-size: 14px; color: #000; line-height: 1.2; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;background-color: rgb(211, 211, 211,0.15);padding: 1.25rem;border-radius: 0.42rem;">

                                                                            @php
                                                                                $emailDescription = \App\CustomFunction\CustomFunction::decode_input($emailDescription);
                                                                            @endphp

                                                                            {!! $emailDescription !!}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;" width="100%">
                                                            <tr>
                                                                <td style="padding: 25px;" >
                                                                    <div style="font-family: sans-serif">
                                                                        <div style="font-size:14px;color:#000;line-height:1.2;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align: center;">
                                                                            <a href="{!! $link !!}" style="color: #ffffff;background-color: #000000;transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease, -webkit-box-shadow 0.15s ease;padding: 10px 35px;font-size: 15px;border-radius: 5px;text-decoration: none;">Sign in to respond</a>
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
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;background-color: #ffffff;padding-bottom: 20px;" width="600">
                                            <tbody>
                                                <tr>
                                                    <th class="column" style="mso-table-lspace: 0; mso-table-rspace: 0; font-weight: 400; text-align: left; vertical-align: top; padding-left: 10px; padding-right: 10px;" width="100%">
                                                        <table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                                                            <tr>
                                                                <td style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:20px;width:100%;">
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
