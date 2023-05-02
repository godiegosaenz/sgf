<!DOCTYPE html>
<html>
<head>
    <title>Generacion de recibo</title>

    <style>
        .container {
			position: relative;
			width: 100%;
			height: 200px;
		}

		.left {
			position: absolute;
			left: 0;
			top: 0;
			width: 50%;
			height: 100%;
            border:solid 1px;
            border-color: #D9D9D9;
		}

		.right {
			position: absolute;
			right: 0;
			top: 0;
			width: 50%;
			height: 100%;
            border:solid 1px;
            border-color: #D9D9D9;

		}
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="">
                <table style="font-size:10px;">
                    <tr>
                        <td><img src="{{asset('img/logogadmsv.jpg')}}" alt="" sizes="" srcset="" height="50px"></td>
                        <td>
                            <table style="text-align: center;margin-rigth:20px">
                                <tr>
                                    <td><strong>GAD MUNICIPAL DEL CANTÓN SAN VICENTE</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>DIRECCIÓN FINANCIERA</strong></td>
                                </tr>
                                <tr>
                                    <td>COMPROBANTE DE RECAUDACIÓN</td>
                                </tr>
                                <tr style="border:solid 1px;border-color:#DEDEDE;">
                                    <td>UNIDAD DE FISIOTERAPIA MUNICIPAL</td>
                                </tr>
                            </table>
                        </td>
                        <td style="text-align:right;">
                            <table style="text-align:right;margin-left:20px">
                                <tr>
                                    <td><img src="{{asset('img/logo.png')}}" alt="" sizes="" srcset="" height="30px"></td>
                                </tr>
                                <tr>
                                    <td style="color:#D31515;">N°: {{str_pad($Liquidation->voucher_number, 6, '0', STR_PAD_LEFT);}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" style="text-align: center"><strong></strong></td>
                    </tr>
                </table>
            </div>
            <div class="">
                <table style="font-size:10px;" >
                    @if($Cita->persona->discapacidad == 'SI')
                    <tr style="background-color: #CFF4FC;">
                        <td>EXONERADO</td>
                    </tr>
                    @endif
                    @foreach ($Liquidation->liquidation_services as $lr)
                        <tr>
                            <td>{{$lr->nombre}}</td>
                            <td style="width:50px;">Tarifa</td>
                            <td style="width:70px;background-color: #{{$lr->descripcion}}">{{$lr->pivot->subtotal}}</td>
                        </tr>
                    @endforeach

                </table>
            </div>
            <div class="">
                <table style="font-size:10px;">
                    <tr>
                        <th >Usuario:</th>
                        <td>{{$Cita->persona->nombres.' '.$Cita->persona->apellidos}}</td>
                    </tr>

                </table>
            </div>
            <br>
            <div class="">
                <table style="font-size:10px" class="mt-5" width="100%">
                    <tr>
                        <td style="width: 50%">________________________</td>
                        <td style="width: 50%">________________________</td>
                    </tr>
                    <tr>
                        <td>Analista de renta Mcpal</td>
                        <td>Unidad de Fisioterapia</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="right">
            <div class="">
                <table style="font-size:10px;">
                    <tr>
                        <td><img src="{{asset('img/logogadmsv.jpg')}}" alt="" sizes="" srcset="" height="50px"></td>
                        <td>
                            <table style="text-align: center;margin-rigth:20px">
                                <tr>
                                    <td><strong>GAD MUNICIPAL DEL CANTÓN SAN VICENTE</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>DIRECCIÓN FINANCIERA</strong></td>
                                </tr>
                                <tr>
                                    <td>COMPROBANTE DE RECAUDACIÓN</td>
                                </tr>
                                <tr style="border:solid 1px;border-color:#DEDEDE;">
                                    <td>UNIDAD DE FISIOTERAPIA MUNICIPAL</td>
                                </tr>
                            </table>
                        </td>
                        <td style="text-align:right;">
                            <table style="text-align:right;margin-left:20px">
                                <tr>
                                    <td><img src="{{asset('img/logo.png')}}" alt="" sizes="" srcset="" height="30px"></td>
                                </tr>
                                <tr>
                                    <td style="color:#D31515;">N°: {{str_pad($Liquidation->voucher_number, 6, '0', STR_PAD_LEFT);}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" style="text-align: center"><strong></strong></td>
                    </tr>
                </table>
            </div>
            <div class="">
                <table style="font-size:10px;" >
                    @if($Cita->persona->discapacidad == 'SI')
                    <tr style="background-color: #CFF4FC;">
                        <td>EXONERADO</td>
                    </tr>
                    @endif
                    @foreach ($Liquidation->liquidation_services as $lr)
                        <tr>
                            <td>{{$lr->nombre}}</td>
                            <td style="width:50px;">Tarifa</td>
                            <td style="width:70px;background-color: #{{$lr->descripcion}}">{{$lr->pivot->subtotal}}</td>
                        </tr>
                    @endforeach

                </table>
            </div>
            <div class="">
                <table style="font-size:10px;">
                    <tr>
                        <th >Usuario:</th>
                        <td>{{$Cita->persona->nombres.' '.$Cita->persona->apellidos}}</td>
                    </tr>

                </table>
            </div>
            <br>
            <div class="">
                <table style="font-size:10px" class="mt-5" width="100%">
                    <tr>
                        <td style="width: 50%">________________________</td>
                        <td style="width: 50%">________________________</td>
                    </tr>
                    <tr>
                        <td>Analista de renta Mcpal</td>
                        <td>Unidad de Fisioterapia</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
