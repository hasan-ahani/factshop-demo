<?php
if ( ! defined( 'ABSPATH' ) )
    die( 'Fizzle' );

?>
<!doctype html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link href="https://fonts.googleapis.com/css?family=Lateef&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Lalezar&display=swap" rel="stylesheet">

    <style type="text/css">
        @media only screen and (min-width: 768px) {
            .templateContainer {
                width: 600px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            body, table, td, p, a, li, blockquote {
                -webkit-text-size-adjust: none !important;
            }

        }

        @media only screen and (max-width: 480px) {
            body {
                width: 100% !important;
                min-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            #bodyCell {
                padding-top: 10px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImage {
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {

            .mcnCaptionTopContent, .mcnCaptionBottomContent, .mcnTextContentContainer, .mcnBoxedTextContentContainer, .mcnImageGroupContentContainer, .mcnCaptionLeftTextContentContainer, .mcnCaptionRightTextContentContainer, .mcnCaptionLeftImageContentContainer, .mcnCaptionRightImageContentContainer, .mcnImageCardLeftTextContentContainer, .mcnImageCardRightTextContentContainer {
                max-width: 100% !important;
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnBoxedTextContentContainer {
                min-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupContent {
                padding: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnCaptionLeftContentOuter
            .mcnTextContent, .mcnCaptionRightContentOuter .mcnTextContent {
                padding-top: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardTopImageContent, .mcnCaptionBlockInner
            .mcnCaptionTopContent:last-child .mcnTextContent {
                padding-top: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardBottomImageContent {
                padding-bottom: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupBlockInner {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupBlockOuter {
                padding-top: 9px !important;
                padding-bottom: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnTextContent, .mcnBoxedTextContentColumn {
                padding-right: 18px !important;
                padding-left: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardLeftImageContent, .mcnImageCardRightImageContent {
                padding-right: 18px !important;
                padding-bottom: 0 !important;
                padding-left: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcpreview-image-uploader {
                display: none !important;
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Heading 1
            @tip Make the first-level headings larger in size for better readability
         on small screens.
            */
            h1 {
                /*@editable*/
                font-size: 20px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Heading 2
            @tip Make the second-level headings larger in size for better
         readability on small screens.
            */
            h2 {
                /*@editable*/
                font-size: 20px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Heading 3
            @tip Make the third-level headings larger in size for better readability
         on small screens.
            */
            h3 {
                /*@editable*/
                font-size: 18px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Heading 4
            @tip Make the fourth-level headings larger in size for better
         readability on small screens.
            */
            h4 {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Boxed Text
            @tip Make the boxed text larger in size for better readability on small
         screens. We recommend a font size of at least 16px.
            */
            .mcnBoxedTextContentContainer
            .mcnTextContent, .mcnBoxedTextContentContainer .mcnTextContent p {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Preheader Visibility
            @tip Set the visibility of the email's preheader on small screens. You
         can hide it to save space.
            */
            #templatePreheader {
                /*@editable*/
                display: block !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Preheader Text
            @tip Make the preheader text larger in size for better readability on
         small screens.
            */
            #templatePreheader .mcnTextContent, #templatePreheader
            .mcnTextContent p {
                /*@editable*/
                font-size: 12px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Header Text
            @tip Make the header text larger in size for better readability on small
         screens.
            */
            #templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Body Text
            @tip Make the body text larger in size for better readability on small
         screens. We recommend a font size of at least 16px.
            */
            #templateBody .mcnTextContent, #templateBody .mcnTextContent p {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Footer Text
            @tip Make the footer content text larger in size for better readability
         on small screens.
            */
            #templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {
                /*@editable*/
                font-size: 12px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }
    </style>
</head>

<!--[if !mso]>
    <!-- -->

<!--<![endif]-->


<body style="
 -ms-text-size-adjust: 100%;
 -webkit-text-size-adjust: 100%;
 background-color: #2196F3;
 height: 100%;
 margin: 0;
 padding: 0;
 width: 100%;
 ">
<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" id="bodyTable" style="
 border-collapse: collapse;
 mso-table-lspace: 0;
 mso-table-rspace: 0;
 -ms-text-size-adjust: 100%;
 -webkit-text-size-adjust:
 100%;
 background-color: #007bff;
 height: 100%;
 margin: 0;
 padding: 0;
 width:
 100%;
 " width="100%">
        <tbody>
        <tr>
            <td align="center" id="bodyCell" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-top: 0;
 height: 100%; margin: 0; padding: 0; width: 100%" valign="top">
                <!-- BEGIN TEMPLATE // -->
                <!--[if gte mso 9]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                    <tr>
                        <td align="center" valign="top" width="600" style="width:600px;">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" class="templateContainer" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; max-width:
 600px; border: 0" width="100%">
                    <tbody>
                    <tr>
                        <td id="templatePreheader" style="
 mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%;
 -webkit-text-size-adjust: 100%;
 background-color: #007bff;
 border-top: 0;
 border-bottom: 0;
 padding-top: 16px;
 padding-bottom: 8px;
 " valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" class="mcnTextBlock" style="border-collapse: collapse; mso-table-lspace: 0;
 mso-table-rspace: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;
 min-width:100%;" width="100%">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td class="mcnTextBlockInner" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%" valign="top">
                                        <table align="left" border="0" cellpadding="0" cellspacing="0"
                                               class="mcnTextContentContainer" style="border-collapse: collapse; mso-table-lspace: 0;
 mso-table-rspace: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust:
 100%; min-width:100%;" width="100%">
                                            <tbody>
                                            <tr>
                                                <td class="mcnTextContent" style="
 mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%;
 -webkit-text-size-adjust: 100%;
 word-break: break-word;
 color: #2a2a2a;
 font-family:  'Lateef' , Helvetica, sans-serif;
 font-size: 12px;
 line-height: 150%;
 text-align: center;
 padding: 24px;
 " valign="top">
                                                    <?php if($logo): ?>
                                                    <a href="<?= $site ?>" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #2a2a2a;
 font-weight: normal; text-decoration: none" target="_blank" title="<?= $title ?>">
                                                        <img align="none" height="32" src="<?= $logo ?>" style="-ms-interpolation-mode: bicubic; border: 0; outline: none;
 text-decoration: none; height: auto; width: auto; height: 75px; margin: 0px;" width="107">
                                                    </a>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td id="templateHeader" style="
 mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%;
 -webkit-text-size-adjust: 100%;
 background-color: #f7f7ff;
 border-top: 0;
 border-bottom: 0;
 padding-top: 16px;
 padding-bottom: 0;
 border-radius: 25px 25px 0 0;
 " valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" class="mcnImageBlock" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;
 min-width:100%;" width="100%">
                                <tbody class="mcnImageBlockOuter">
                                <tr>
                                    <td class="mcnImageBlockInner" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding:0px" valign="top">
                                        <table align="left" border="0" cellpadding="0" cellspacing="0"
                                               class="mcnImageContentContainer" style="border-collapse: collapse; mso-table-lspace: 0;
 mso-table-rspace: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust:
 100%; min-width:100%;" width="100%">
                                            <tbody>
                                            <tr>
                                                <td class="mcnImageContent" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-right: 0px;
 padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;" valign="top">
                                                    <?php if($image): ?>
                                                    <a class="" href="<?= $site ?>" style="mso-line-height-rule:
 exactly; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color:
 #f57153; font-weight: normal; text-decoration: none" target="_blank">
                                                        <img align="center" class="mcnImage"
                                                             src="<?= $image ?>"
                                                             style="-ms-interpolation-mode: bicubic; border: 0; height: auto; outline: none;
 text-decoration: none; vertical-align: bottom; max-width:1200px; padding-bottom:
 0; display: inline !important; vertical-align: bottom; mix-blend-mode: darken;" width="600">
                                                    </a>
                                                    <?php endif;?>

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td id="templateBody" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f7f7ff;
 border-top: 0; border-bottom: 0; padding-top: 0; padding-bottom: 0" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" class="mcnTextBlock" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; min-width:100%;" width="100%">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td class="mcnTextBlockInner" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%" valign="top">
                                        <table align="left" border="0" cellpadding="0" cellspacing="0"
                                               class="mcnTextContentContainer" style="border-collapse: collapse; mso-table-lspace: 0;
 mso-table-rspace: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust:
 100%; min-width:100%;" width="100%">
                                            <tbody>
                                            <tr>
                                                <td class="mcnTextContent" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; word-break: break-word;
 color: #2a2a2a; font-family:  'Lateef' , Helvetica, sans-serif; font-size: 16px;
 line-height: 150%; text-align: center; padding-top:9px; padding-right: 18px;
 padding-bottom: 9px; padding-left: 18px;" valign="top">



                                                    <h2 class="null" style="
 color: #2a2a2a;
 font-family: 'Lalezar', 'Lateef' , Helvetica,
 sans-serif;
 font-size: 24px;
 font-style: normal;
 font-weight: bold;
 line-height:
 125%;
 text-align: center;
 display: block;
 margin: 0;
 padding: 0;
 "><span style="text-transform:uppercase"><?= $subject ?></span></h2>

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table border="0" cellpadding="0" cellspacing="0" class="mcnTextBlock" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace:
 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;
 min-width:100%;" width="100%">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td class="mcnTextBlockInner" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%" valign="top">
                                        <table align="left" border="0" cellpadding="0" cellspacing="0"
                                               class="mcnTextContentContainer" style="border-collapse: collapse; mso-table-lspace: 0;
 mso-table-rspace: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust:
 100%; min-width:100%;" width="100%">
                                            <tbody>
                                            <tr>
                                                <td class="mcnTextContent" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; word-break: break-word;
 color: #2a2a2a; font-family: Tahoma,Verdana,Segoe,sans-serif; font-size: 16px;
 line-height: 150%; text-align: right; padding-top:9px; padding-right: 18px;
 padding-bottom: 9px; padding-left: 18px; direction: rtl;" valign="top"><?= $content ?><br><br>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonBlock" style="border-collapse: collapse; mso-table-lspace: 0;
 mso-table-rspace: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;
 min-width:100%;" width="100%">
                                <tbody class="mcnButtonBlockOuter">
                                <tr>
                                    <td align="center" class="mcnButtonBlockInner" style="mso-line-height-rule:
 exactly; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;
 padding-top:18px; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonBlock" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; min-width:100%;" width="100%">
                                            <tbody class="mcnButtonBlockOuter">
                                            <tr>
                                                <td align="center" class="mcnButtonBlockInner" style="mso-line-height-rule:
 exactly; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;
 padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top">
                                                    <?php if($button):  ?>
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                           class="mcnButtonContentContainer" style="
 border-collapse: collapse;
 mso-table-lspace: 0;
 mso-table-rspace: 0;
 -ms-text-size-adjust: 100%;
 -webkit-text-size-adjust: 100%;
 border-collapse: separate !important;
 border-radius: 48px;
 background-color: #007bff;
 ">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" class="mcnButtonContent" style="mso-line-height-rule:
 exactly; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;
 font-family: Tahoma,Verdana,Segoe,sans-serif; font-size: 16px; padding-top:24px;
 padding-right:48px; padding-bottom:24px; padding-left:48px;" valign="middle">
                                                                <?= $button ?>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                        <?php endif; ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table border="0" cellpadding="0" cellspacing="0" class="mcnImageBlock" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; min-width:100%;" width="100%">
                                <tbody class="mcnImageBlockOuter">
                                <tr>
                                    <td class="mcnImageBlockInner" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding:0px" valign="top">
                                        <table align="left" border="0" cellpadding="0" cellspacing="0"
                                               class="mcnImageContentContainer" style="border-collapse: collapse; mso-table-lspace: 0;
 mso-table-rspace: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust:
 100%; min-width:100%;" width="100%">
                                            <tbody>
                                            <tr>
                                                <td class="mcnImageContent" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-right: 0px;
 padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;" valign="top"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td id="templateFooter" style="
 mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%;
 -webkit-text-size-adjust: 100%;
 background-color: #007bff;
 border-top: 0;
 border-bottom: 0;
 padding-top: 8px;
 padding-bottom: 80px;
 " valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" class="mcnTextBlock" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; min-width:100%;" width="100%">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td class="mcnTextBlockInner" style="mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%" valign="top">
                                        <table align="center" bgcolor="#F7F7FF" border="0" cellpadding="32"
                                               cellspacing="0" class="card" style="
 border-collapse: collapse;
 mso-table-lspace: 0;
 mso-table-rspace: 0;
 -ms-text-size-adjust: 100%;
 -webkit-text-size-adjust:
 100%;
 background:#F7F7FF;
 margin:auto;
 text-align: right;
 max-width:600px;
 font-family: ''Lateef'', Helvetica, sans-serif;
 " text-align="left" width="100%">
                                            <tbody>
                                            <tr>
                                                <td style="mso-line-height-rule: exactly; -ms-text-size-adjust: 100%;  direction: rtl;
 -webkit-text-size-adjust: 100%">
                                                    <?= $info ?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0;
 -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; min-width:100%;" width="100%">
                                            <tbody>
                                            <tr>
                                                <td style="
 mso-line-height-rule: exactly;
 -ms-text-size-adjust: 100%;
 -webkit-text-size-adjust: 100%;
 padding-top: 24px;
 padding-right: 18px;
 padding-bottom: 24px;
 padding-left: 18px;
 color: #ffffff;
 font-family: Tahoma,Verdana,Segoe,sans-serif;
 font-size: 12px;
 " valign="top">
                                                    <div style="text-align: center;  direction: rtl;"><?= $copyright ?></div>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tbody></tbody>

                                        </table>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--[if gte mso 9]>
                </td>
                </tr>
                </table>
                <![endif]-->
                <!-- // END TEMPLATE -->
            </td>
        </tr>
        </tbody>
    </table>
</center>

</body>
</html>