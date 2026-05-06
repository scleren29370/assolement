<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class parcelle  extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insertion des parcelles initiales avec leurs surfaces';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            INSERT INTO parcelle (nom, surface) VALUES
            ('STABULATION', 1.62),
            ('KERLOA 1', 2.35),
            ('KERLOA 2', 1.80),
            ('KERLOA 3', 3.29),
            ('KERLOA 4', 2.12),
            ('KERLOA 5', 2.50),
            ('KERLOA 6', 3.64),
            ('KERLOA 7', 5.53),
            ('SPERNIGOU', 3.27),
            ('NOUVEAU KERLOA', 8.00),
            ('PRAIRIE BERTAND', 0.55),
            ('PETITE PRAIRIE', NULL),
            ('GRANDE PRAIRIE', NULL),
            ('PRAIRIE FONTAINE', NULL),
            ('GOURIOU', 1.98),
            ('CHAMP HULL', 2.37),
            ('FACE VIEILLE PATURE', 4.21),
            ('HAUT VIEILLE PATURE', 1.46),
            ('VIEILLE PATURE', 4.14),
            ('BAS FOSSE', NULL),
            ('MICHEL', 2.06),
            ('LOUZONIG', 2.29),
            ('PARC TRAVAN', NULL),
            ('LA GARENNE', NULL),
            ('VAG VOIN', 1.11),
            ('CHAMP POMMIER', 2.54),
            ('CHAMP KERBREBEL', 2.39),
            ('ROUTE TY MOTTER', 0.70),
            ('PRAIRIE TY MOTTER', 0.70),
            ('GOAREM BELLA', 0.89),
            ('GOAREM BELLA HANGAR', 0.45),
            ('MINE TREOUZAL GRANDE', 2.97),
            ('MINE TREOUZAL CHRISTIAN', 1.25),
            ('MINE TREOUZAL MILIEU', 2.67),
            ('MINE TREOUZAL CONTRE GRAND', 1.61)
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("
            DELETE FROM parcelle WHERE nom IN (
                'STABULATION','KERLOA 1','KERLOA 2','KERLOA 3','KERLOA 4','KERLOA 5','KERLOA 6','KERLOA 7',
                'SPERNIGOU','NOUVEAU KERLOA','PRAIRIE BERTAND','PETITE PRAIRIE','GRANDE PRAIRIE','PRAIRIE FONTAINE',
                'GOURIOU','CHAMP HULL','FACE VIEILLE PATURE','HAUT VIEILLE PATURE','VIEILLE PATURE','BAS FOSSE',
                'MICHEL','LOUZONIG','PARC TRAVAN','LA GARENNE','VAG VOIN','CHAMP POMMIER','CHAMP KERBREBEL',
                'ROUTE TY MOTTER','PRAIRIE TY MOTTER','GOAREM BELLA','GOAREM BELLA HANGAR',
                'MINE TREOUZAL GRANDE','MINE TREOUZAL CHRISTIAN','MINE TREOUZAL MILIEU','MINE TREOUZAL CONTRE GRAND'
            );
        ");
    }
}
