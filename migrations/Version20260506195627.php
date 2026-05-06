<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260506195627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat_produit (id INT AUTO_INCREMENT NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, quantite DOUBLE PRECISION NOT NULL, date_achat DATE NOT NULL, produit_id INT NOT NULL, campagne_id INT NOT NULL, INDEX IDX_C26FA378F347EFB (produit_id), INDEX IDX_C26FA37816227374 (campagne_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE assolement (id INT AUTO_INCREMENT NOT NULL, date_semis DATE DEFAULT NULL, date_recolte DATE DEFAULT NULL, tonnage DOUBLE PRECISION DEFAULT NULL, surface DOUBLE PRECISION DEFAULT NULL, parcelle_id INT DEFAULT NULL, culture_id INT DEFAULT NULL, campagne_id INT DEFAULT NULL, INDEX IDX_4E02B0524433ED66 (parcelle_id), INDEX IDX_4E02B052B108249D (culture_id), INDEX IDX_4E02B05216227374 (campagne_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE campagne (id INT AUTO_INCREMENT NOT NULL, annee VARCHAR(10) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE culture (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, quantite_totale DOUBLE PRECISION NOT NULL, date_livraison DATE NOT NULL, acheteur VARCHAR(150) DEFAULT NULL, culture_id INT NOT NULL, campagne_id INT NOT NULL, INDEX IDX_A60C9F1FB108249D (culture_id), INDEX IDX_A60C9F1F16227374 (campagne_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE parcelle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, surface DOUBLE PRECISION NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, type VARCHAR(50) NOT NULL, unite VARCHAR(20) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE traitement (id INT AUTO_INCREMENT NOT NULL, dose DOUBLE PRECISION NOT NULL, unite VARCHAR(20) NOT NULL, date_traitement DATE NOT NULL, commentaire LONGTEXT DEFAULT NULL, assolement_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_2A356D273B2F034 (assolement_id), INDEX IDX_2A356D27F347EFB (produit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE achat_produit ADD CONSTRAINT FK_C26FA378F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE achat_produit ADD CONSTRAINT FK_C26FA37816227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B0524433ED66 FOREIGN KEY (parcelle_id) REFERENCES parcelle (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B052B108249D FOREIGN KEY (culture_id) REFERENCES culture (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B05216227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FB108249D FOREIGN KEY (culture_id) REFERENCES culture (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F16227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D273B2F034 FOREIGN KEY (assolement_id) REFERENCES assolement (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D27F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat_produit DROP FOREIGN KEY FK_C26FA378F347EFB');
        $this->addSql('ALTER TABLE achat_produit DROP FOREIGN KEY FK_C26FA37816227374');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B0524433ED66');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B052B108249D');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B05216227374');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FB108249D');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F16227374');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D273B2F034');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D27F347EFB');
        $this->addSql('DROP TABLE achat_produit');
        $this->addSql('DROP TABLE assolement');
        $this->addSql('DROP TABLE campagne');
        $this->addSql('DROP TABLE culture');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE parcelle');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE traitement');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
