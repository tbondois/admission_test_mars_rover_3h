<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908171304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plateau (id INT AUTO_INCREMENT NOT NULL, max_position_id INT DEFAULT NULL, INDEX IDX_5CA87FDC602AAF69 (max_position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, x INT NOT NULL, y INT NOT NULL, orientation VARCHAR(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rover (id INT AUTO_INCREMENT NOT NULL, position_id INT DEFAULT NULL, moveset VARCHAR(500) NOT NULL, INDEX IDX_D08838F7DD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plateau ADD CONSTRAINT FK_5CA87FDC602AAF69 FOREIGN KEY (max_position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE rover ADD CONSTRAINT FK_D08838F7DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plateau DROP FOREIGN KEY FK_5CA87FDC602AAF69');
        $this->addSql('ALTER TABLE rover DROP FOREIGN KEY FK_D08838F7DD842E46');
        $this->addSql('DROP TABLE plateau');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE rover');
    }
}
