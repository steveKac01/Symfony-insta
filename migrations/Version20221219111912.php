<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221219111912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact CHANGE name name VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD avatar_choosed_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491171C9FA FOREIGN KEY (avatar_choosed_id) REFERENCES avatar (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491171C9FA ON user (avatar_choosed_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491171C9FA');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('ALTER TABLE contact CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_8D93D6491171C9FA ON user');
        $this->addSql('ALTER TABLE user DROP avatar_choosed_id');
    }
}
