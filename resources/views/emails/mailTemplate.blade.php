<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ trans('english.PROJECT_TITLE') }}</title>

</head>

<body bgcolor="#FFFFFF">
    
    <!--HEADER-->
    <!-- <table class="head-wrap" bgcolor="#999999">
        <tr>
            <td></td>
            <td class="header container">

                <div class="content">
                    <table bgcolor="#999999" style="width: 100%;">
                        <tr>
                            <td style="width:80%;">
                                <img src="{{ URL::to('/') }}/public/backend/dist/img/AdminLogo.pngp" alt="{{ trans('english.PROJECT_TITLE') }}"
                                    class="logo-default" /> </a>
                            </td>
                            <td align="right" style="width:20%;">
                                <h6 class="collapse">{{ trans('english.PROJECT_TITLE') }}</h6>
                            </td>
                        </tr>

                    </table>
                </div>

            </td>
            <td></td>
        </tr>
    </table> -->

    <!-- BODY -->
    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" bgcolor="#FFFFFF">

                <div class="content">
                    <table>
                        <tr>
                            <td>
                                <h3>Dear {{ $userName ?? '' }},</h3>
                                <p class="lead">{{ $body ?? '' }}</p>
                               
                            </td>
                        </tr>
                    </table>
                </div><!-- /content -->

            </td>
            <td></td>
        </tr>
    </table><!-- /BODY -->

    <!-- FOOTER -->
    <table class="footer-wrap">
        <tr>
            <td></td>
            <td class="container">

                <!-- content -->
                <div class="content">
                    <table>
                        <tr>
                            <td align="center">
                                <p>
                                    Copyright © <?php echo date('Y'); ?> @lang('english.PROJECT_TITLE')
                                </p>
                            </td>
                        </tr>
                    </table>
                </div><!-- /content -->

            </td>
            <td></td>
        </tr>
    </table><!-- /FOOTER -->

</body>

</html>
