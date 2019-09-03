@extends('emails.default')

@section('mail-body')
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <h5 style="text-align: center;">Вас приветсвтует команда {{env('CHEAT_NAME')}}</h5>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 0 30px 0;">
                <p>Вы успешно зарегестрировались на <a href="{{url('/')}}" target="_blank" style="text-decoration: none; color: #007bee">сайте</a>.</p>
                <p>Для подтверждения Вашей учетной записи, перейдите по следующей <a href="{{url("/confirm/".@$confirm_link)}}" target="_blank" style="text-decoration: none; color: #007bee; text-transform: uppercase;">ссылке</a>.</p>
            </td>
        </tr>
    </table>
@endsection
