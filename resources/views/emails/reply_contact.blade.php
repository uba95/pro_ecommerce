<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body
    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #f8fafc; color: #74787e; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    {{-- header --}}

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation"
    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #f8fafc; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
        <tr>
            <td align="center"
                style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box;">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                    <tr>
                        <td class="header"
                            style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; padding: 15px; text-align: left;">
                            <a href="http://ec.test"
                                style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
                                {{ config('app.name') }}
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @if (!$contactMessage->replied)
        
    {{-- contact message --}}

    <div style="margin-top:25px">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
            <tbody>
                <tr>
                    <td width="100%" style="padding:15px 0;border-top:1px dotted #c5c5c5">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed"
                            role="presentation">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding:0 15px 0 15px;width:40px"> <img width="40"
                                            height="40" alt=""
                                            style="height:auto;line-height:100%;outline:none;text-decoration:none;border-radius:5px"
                                            src="https://ci5.googleusercontent.com/proxy/DySKMFlSOlit0IpnmSu-ZRWVb7H-RWjwcxOg-MA_lXMRjFEtQQiOFWgd2pDwFOt7ZEJCPW2i8GGwhQvIJ5Kls0ZXwYEF_MhHqqwufpeaCD1ErkQw2ioXHtfRliGvP1MIF3MDLcWgSNdyUzsKpWfeyhUiXeeqN3uGnFbrO9xdd8Eu92fj11JNYiULRtBnEP2onB7VuXbsFgZa5OMChMkyV7AHT91zYjdO4LDNdRU4bN32Uoae=s0-d-e1-ft#https://secure.gravatar.com/avatar/93dfec668491d97d1558945675289cc4?size=40&amp;default=https%3A%2F%2Fassets.zendesk.com%2Fimages%2F2016%2Fdefault-avatar-80.png&amp;r=g"
                                            class="CToWUd"> </td>
                                    <td width="100%" style="padding:0;margin:0" valign="top">
                                        <p style="font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans',Verdana,Tahoma,sans-serif;font-size:15px;line-height:18px;margin-bottom:0;margin-top:0;padding:0;color:#1b1d1e"
                                            dir="ltr"> <strong>{{ $contactMessage->name }}</strong> </p>
                                        <p style="font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans',Verdana,Tahoma,sans-serif;font-size:13px;line-height:25px;margin-bottom:15px;margin-top:0;padding:0;color:#bbbbbb"
                                            dir="ltr"> {{ $contactMessage->created_at->toRfc7231String() }} </p><span class="im">
                                            <div dir="auto"
                                                style="color:#2b2e2f;font-family:'Lucida Sans Unicode','Lucida Grande','Tahoma',Verdana,sans-serif;font-size:14px;line-height:22px;margin:15px 0">
                                                <p style="color:#2b2e2f;font-family:'Lucida Sans Unicode','Lucida Grande','Tahoma',Verdana,sans-serif;font-size:14px;line-height:22px;margin:15px 0"
                                                    dir="ltr">
                                                    {{ $contactMessage->message  }}
                                                </p>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    {{-- reply --}}

    <div style="margin-top:25px">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
            <tbody>
                <tr>
                    <td width="100%" style="padding:15px 0;border-top:1px dotted #c5c5c5;border-bottom:1px dotted #c5c5c5">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed"
                            role="presentation">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding:0 15px 0 15px;width:40px"> <img width="40"
                                            height="40" alt=""
                                            style="height:auto;line-height:100%;outline:none;text-decoration:none;border-radius:5px"
                                            src="https://ci5.googleusercontent.com/proxy/DySKMFlSOlit0IpnmSu-ZRWVb7H-RWjwcxOg-MA_lXMRjFEtQQiOFWgd2pDwFOt7ZEJCPW2i8GGwhQvIJ5Kls0ZXwYEF_MhHqqwufpeaCD1ErkQw2ioXHtfRliGvP1MIF3MDLcWgSNdyUzsKpWfeyhUiXeeqN3uGnFbrO9xdd8Eu92fj11JNYiULRtBnEP2onB7VuXbsFgZa5OMChMkyV7AHT91zYjdO4LDNdRU4bN32Uoae=s0-d-e1-ft#https://secure.gravatar.com/avatar/93dfec668491d97d1558945675289cc4?size=40&amp;default=https%3A%2F%2Fassets.zendesk.com%2Fimages%2F2016%2Fdefault-avatar-80.png&amp;r=g"
                                            class="CToWUd"> </td>
                                    <td width="100%" style="padding:0;margin:0" valign="top">
                                        <p style="font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans',Verdana,Tahoma,sans-serif;font-size:15px;line-height:18px;margin-bottom:0;margin-top:0;padding:0;color:#1b1d1e"
                                            dir="ltr"> <strong>{{ config('app.name') }}</strong> </p>
                                        <p style="font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans',Verdana,Tahoma,sans-serif;font-size:13px;line-height:25px;margin-bottom:15px;margin-top:0;padding:0;color:#bbbbbb"
                                            dir="ltr"> {{ now()->toRfc7231String() }} </p><span class="im">
                                            <div dir="auto"
                                                style="color:#2b2e2f;font-family:'Lucida Sans Unicode','Lucida Grande','Tahoma',Verdana,sans-serif;font-size:14px;line-height:22px;margin:15px 0">
                                                <p style="color:#2b2e2f;font-family:'Lucida Sans Unicode','Lucida Grande','Tahoma',Verdana,sans-serif;font-size:14px;line-height:22px;margin:15px 0"
                                                    dir="ltr">
                                                    {!! $reply->reply  !!}
                                                </p>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- footer --}}

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation"
        style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #f8fafc; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
        <tr>
            <td align="center"
                style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box;">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                    <tr>
                        <td
                            style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box;">
                            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation"
                                style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; margin: 0; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                <tr>
                                    <td class="content-cell" align="center"
                                        style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; padding: 15px;">
                                        <p
                                            style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #aeaeae; font-size: 12px; text-align: left;">
                                            © 2021 {{ config('app.name') }}. All rights reserved.</p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>