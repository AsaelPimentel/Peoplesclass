<?php
class TraductorDia {
    public static function traducir($dia) {
        switch ($dia) {
            case 'Monday':
                return 'Lunes';
                break;
            case 'Tuesday':
                return 'Martes';
                break;
            case 'Wednesday':
                return 'Miércoles';
                break;
            case 'Thursday':
                return 'Jueves';
                break;
            case 'Friday':
                return 'Viernes';
                break;
            case 'Saturday':
                return 'Sábado';
                break;
            case 'Sunday':
                return 'Domingo';
                break;
            default:
                return '';
                break;
        }
    }
}
?>
