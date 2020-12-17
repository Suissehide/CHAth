<?php

namespace App\Constant;

class FormConstants {
    const INCLUSION = [
        'Patients (homme ou femme) âgés de plus de 75 ans',
        'Patient présentant un premier ECV (Infarctus du myocarde - IDM) d’origine athéromateuse datant de 6 mois (+/- 15 jours)',
        'Absence de preuve pour une hémopathie maligne avérée (connue ou révélée sur les résultats de NFS)',
        'Sujet affilié ou bénéficiaire d’un régime de sécurité sociale',
        'Signature du consentement éclairé'
    ];

    const NON_INCLUSION = [
        'Patient ayant présenté un ECV d’origine non-athéromateuse (dissection, embolique, ...)',
        'Patient présentant un diabète mal équilibré (HbA1c > 10%)',
        'Patient ayant présenté un ou plusieurs ECV avant 75 ans : IDM, coronaropathie, AOMI, sténose carotidienne significative, accident vasculaire cérébral (AVC) d’origine athéromateuse',
        'Patient présentant une hémopathie maligne manifeste (connue ou révélée sur les résultats de NFS)',
        'Patient présentant une maladie inflammatoire chronique (cancer, vascularite, rhumatismale, hépato-gastro-intestinales)',
        'Patient traité par anti-inflammatoire au long cours (Corticoïdes, Anti-inflammatoires non stéroïdiens, Aspirine > 325mg/jour, Inhibiteurs de la cyclo-oxygénase II)',
        'Personne placée sous sauvegarde de justice, tutelle ou curatelle',
        'Personne étant dans l’incapacité de donner son consentement',
        'Sujet non coopérant'
    ];

    const FACTEUR = [
        'Diabète',
        'Hypertension artérielle',
        'Dyslipidémie'
    ];

    const CARDIO_TRAITEMENT = [
        'Hypocholestérolémiant',
        'Antihypertenseur',
        'Antidiabétique',
        'Antiagrégant'
    ];

    const TYPE = [
        'Sus-décalage du segment ST',

        'Antérieur',
        'Septo-apical',
        'Latéral',
        'Inférieur / Postérieur',
        'Sans territoire',

        'IVA',
        'CD',
        'Cx',
        'Marginale',
        'Diagonale',
        'Pontage',
        'Tronc commun'
    ];

    const COMPLICATION = [
        'Trouble du rythme ventriculaire',
        'Insuffisance cardiaque',
        'Péricardite',
        'Complication mécanique'
    ];

    const DONNEE_TRAITEMENT = [
        'Bêta-bloquant',
        'Aspirine',
        'Inhibiteur du récepteur P2Y12',
        'Statine',
        'Inhibiteur de l’Enzyme de Conversion',
        'Antagoniste du récepteur de l’angiotensine 2'
    ];

    const GENES = [
        'ANKRD',
        'ASXL1',
        'ASXL2',
        'BCOR',
        'BCORL',
        'CALR',
        'CBL',
        'CCND2',
        'CEBPA',
        'CSF3R',
        'CUX1',
        'DDX41',
        'DHX15',
        'DNMT3',
        'ETNK1',
        'ETV6',
        'EZH2',
        'FLT3',
        'GATA1',
        'GATA2',
        'GNAS',
        'GNB1',
        'IDH1',
        'IDH2',
        'IKZF1',
        'JAK2',
        'KDM6A',
        'KIT',
        'KMT2C',
        'KRAS',
        'MPL',
        'MYC',
        'NFE2',
        'NPM1',
        'NRAS',
        'PHF6',
        'PPM1D',
        'PTEN',
        'PTPN1',
        'RAD21',
        'RIT1',
        'RUNX1',
        'SAMD9',
        'SAMD9',
        'SETBP',
        'SF3B1',
        'SH2B3',
        'SMC1A',
        'SMC3',
        'SRSF2',
        'SRY',
        'STAG2',
        'TERC',
        'TERT',
        'TP53',
        'U2AF1',
        'WT1',
        'ZRSR2'
    ];
}