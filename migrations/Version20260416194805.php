<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260416194805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traitement_assolement (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, produit VARCHAR(100) NOT NULL, dose VARCHAR(50) NOT NULL, unite VARCHAR(20) NOT NULL, date_traitement DATE NOT NULL, commentaire LONGTEXT DEFAULT NULL, assolement_id INT NOT NULL, INDEX IDX_AAE7AEBD3B2F034 (assolement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE traitement_assolement ADD CONSTRAINT FK_AAE7AEBD3B2F034 FOREIGN KEY (assolement_id) REFERENCES assolement (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B0524433ED66 FOREIGN KEY (parcelle_id) REFERENCES parcelle (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B052B108249D FOREIGN KEY (culture_id) REFERENCES culture (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B05216227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traitement_assolement DROP FOREIGN KEY FK_AAE7AEBD3B2F034');
        $this->addSql('DROP TABLE traitement_assolement');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B0524433ED66');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B052B108249D');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B05216227374');
    }
}
