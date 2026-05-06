<?php

namespace App\Reference;

class Referentiel
{
    /* ============================
       TYPES DE TRAITEMENT
       ============================ */
    public const TRAITEMENT_HERBICIDE   = 'herbicide';
    public const TRAITEMENT_FONGICIDE   = 'fongicide';
    public const TRAITEMENT_INSECTICIDE = 'insecticide';
    public const TRAITEMENT_ENGRAIS     = 'engrais';
    public const TRAITEMENT_AUTRE       = 'autre';

    public static function typesProduit(): array
    {
        return [
            self::TRAITEMENT_HERBICIDE,
            self::TRAITEMENT_FONGICIDE,
            self::TRAITEMENT_INSECTICIDE,
            self::TRAITEMENT_ENGRAIS,
            self::TRAITEMENT_AUTRE,
        ];
    }

    /* ============================
       UNITÉS DE DOSE
       ============================ */
    public const UNITE_L_HA = 'L/ha';
    public const UNITE_KG_HA = 'kg/ha';
    public const UNITE_G_HL = 'g/hl';
    public const UNITE_ML_HA = 'mL/ha';

    public static function unitesDose(): array
    {
        return [
            self::UNITE_L_HA,
            self::UNITE_KG_HA,
            self::UNITE_G_HL,
            self::UNITE_ML_HA,
        ];
    }

    /* ============================
       FAMILLES DE PRODUITS
       ============================ */
    public const FAMILLE_GLYPHOSATE   = 'glyphosate';
    public const FAMILLE_TRIAZOLE     = 'triazole';
    public const FAMILLE_SULFONYLUREE = 'sulfonylurée';
    public const FAMILLE_PYRETHRINOIDE = 'pyréthrinoïde';

    public static function famillesProduit(): array
    {
        return [
            self::FAMILLE_GLYPHOSATE,
            self::FAMILLE_TRIAZOLE,
            self::FAMILLE_SULFONYLUREE,
            self::FAMILLE_PYRETHRINOIDE,
        ];
    }

    /* ============================
       TYPES DE CULTURE
       ============================ */
    public const CULTURE_CEREALE     = 'céréale';
    public const CULTURE_LEGUMINEUSE = 'légumineuse';
    public const CULTURE_OLEAGINEUX  = 'oléagineux';
    public const CULTURE_FOURRAGE    = 'fourrage';

    public static function typesCulture(): array
    {
        return [
            self::CULTURE_CEREALE,
            self::CULTURE_LEGUMINEUSE,
            self::CULTURE_OLEAGINEUX,
            self::CULTURE_FOURRAGE,
        ];
    }

    /* ============================
       STATUTS DE TRAITEMENT
       ============================ */
    public const STATUT_PREVU   = 'prévu';
    public const STATUT_REALISE = 'réalisé';
    public const STATUT_ANNULE  = 'annulé';

    public static function statutsTraitement(): array
    {
        return [
            self::STATUT_PREVU,
            self::STATUT_REALISE,
            self::STATUT_ANNULE,
        ];
    }
}
