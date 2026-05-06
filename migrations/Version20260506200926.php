<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260506200926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livraison_assolement (livraison_id INT NOT NULL, assolement_id INT NOT NULL, INDEX IDX_AAF1BE5C8E54FB25 (livraison_id), INDEX IDX_AAF1BE5C3B2F034 (assolement_id), PRIMARY KEY (livraison_id, assolement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE livraison_assolement ADD CONSTRAINT FK_AAF1BE5C8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livraison_assolement ADD CONSTRAINT FK_AAF1BE5C3B2F034 FOREIGN KEY (assolement_id) REFERENCES assolement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE achat_produit ADD CONSTRAINT FK_C26FA378F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE achat_produit ADD CONSTRAINT FK_C26FA37816227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B0524433ED66 FOREIGN KEY (parcelle_id) REFERENCES parcelle (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B052B108249D FOREIGN KEY (culture_id) REFERENCES culture (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B05216227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id)');
        $this->addSql('DROP INDEX IDX_A60C9F1FB108249D ON livraison');
        $this->addSql('ALTER TABLE livraison DROP culture_id, CHANGE acheteur acheteur VARCHAR(255) DEFAULT NULL, CHANGE campagne_id campagne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F16227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D273B2F034 FOREIGN KEY (assolement_id) REFERENCES assolement (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D27F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_assolement DROP FOREIGN KEY FK_AAF1BE5C8E54FB25');
        $this->addSql('ALTER TABLE livraison_assolement DROP FOREIGN KEY FK_AAF1BE5C3B2F034');
        $this->addSql('DROP TABLE livraison_assolement');
        $this->addSql('ALTER TABLE achat_produit DROP FOREIGN KEY FK_C26FA378F347EFB');
        $this->addSql('ALTER TABLE achat_produit DROP FOREIGN KEY FK_C26FA37816227374');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B0524433ED66');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B052B108249D');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B05216227374');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F16227374');
        $this->addSql('ALTER TABLE livraison ADD culture_id INT NOT NULL, CHANGE acheteur acheteur VARCHAR(150) DEFAULT NULL, CHANGE campagne_id campagne_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_A60C9F1FB108249D ON livraison (culture_id)');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D273B2F034');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D27F347EFB');
    }
}
