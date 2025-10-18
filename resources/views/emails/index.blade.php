<!DOCTYPE html>
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

@php
use App\Models\product;
$product = product::with('images')->latest('id')->first();


@endphp

<body style="margin: 0; font-family: Open Sans, Helvetica, Arial, sans-serif; background-color: #ffffff; -webkit-font-smoothing: antialiased;">
    <center>
        <div align="center">
            @if($product)
            <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" style="background-color: #FAFAFA; border-spacing: 0; width: 100%;">
                <tbody>
                    <tr>
                        <td style="padding: 0;">
                            <div align="center" style="max-width: 560px; margin: 0 auto;">
                                <div style="background-color: #FAFAFA; max-width: 560px;">
                                    <div style="font-size: 18px; color: #363636; padding: 0; line-height: 1.5em;">
                                        <table width="100%" style="border-spacing: 0;">
                                            <tr>
                                                <td style="padding: 0;">
                                                    <div style="padding: 20px; background-color: #FFFFFF;">
                                                        <table width="100%" style="border-spacing: 0;">
                                                            <tr>
                                                                @if(isset($product['images'][0]->image))
                                                                <td>
                                                                    <img src="https://api.biznetusa.com/uploads/products/{{ $product['images'][0]->image }}" alt="No Image Found" style="width: 100% !important; height: 60% !important; border: none;">
                                                                </td>
                                                                @endif
                                                            </tr>
                                                        </table>
                                               <div style="color: #363636; font-size: 18px; line-height: 1.5em; margin-top: 10px;">
                                                            <p>{{ $product->location }}<br>{{ $product->title }}<br><span style="color:#ffc62c">★★★★</span><span style="color:#c1c1c1">★</span> &nbsp;Rating</p>
                                                        </div>
                                                        <div style="text-align: center; color: #363636; font-size: 16px; margin-top: 10px;">
                                                           <em>{{ strlen($product->desc) > 150 ? substr($product->desc, 0, 150) . '...' : $product->desc }}</em>
                                                        </div>
                                                        <div style="text-align: center; margin-top: 20px;">
                                                            <a href="https://znetrealty.com/ProductDetail/{{ $product->id }}" target="_blank" style="font-size: 16px; color: #3E3E3E; background-color: #FFCB32; padding: 10px 40px; border-radius: 100px; box-shadow: rgba(204, 204, 204, 0.6) 0px 4px 8px -2px; text-decoration: none; font-weight: 600;">See more</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                     
                                        <div style="text-align: center; margin: 20px 0;">
                                          
                                        </div>
                                        <div style="text-align: center;">
                                            <a href="#" style="text-decoration: none;">
                                                <img src="https://www.aweber.com/images/email-templates/structures/social-fb.png" alt="facebook" style="width: 30px; height: 30px; margin: 0 5px;">
                                            </a>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="https://www.aweber.com/images/email-templates/structures/social-twitter.png" alt="twitter" style="width: 30px; height: 30px; margin: 0 5px;">
                                            </a>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="https://www.aweber.com/images/email-templates/structures/social-ig.png" alt="instagram" style="width: 30px; height: 30px; margin: 0 5px;">
                                            </a>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="https://www.aweber.com/images/email-templates/structures/social-youtube.png" alt="youtube" style="width: 30px; height: 30px; margin: 0 5px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            @else
            <h3 style="text-center;">No Product Found!</h3>
            
            @endif
        </div>
    </center>
</body>

</html>
