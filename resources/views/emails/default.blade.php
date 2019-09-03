<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{app()->getLocale()}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{@$mail_title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0; font-family: Helvetica, Arial, sans-serif;">
<table align="center" border="1" cellpadding="0" cellspacing="0" width="600">
    <tr>
        <td align="center" >
            <h2>{{@$mail_header}}</h2>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 30px;">
            @yield('mail-body')
        </td>
    </tr>
    <tr>
        <td style="padding: 30px 0 30px 0">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="350" style="padding: 0 0 0 50px">
                        <table>
                            <tr>
                                <td>
                                    <a href="{{env('TELEGRAM_LINK')}}" target="_blank" style="text-decoration: none; color: #b4b4b4">Telegram</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{env('VK_LINK')}}" target="_blank" style="text-decoration: none; color: #b4b4b4">VK</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="font-size: 14px; color: #828282;" width="350">
                        Это письмо отправлено автоматически, пожалуйста, не отвечайте на него.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
