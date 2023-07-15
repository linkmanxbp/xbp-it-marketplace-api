<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230715135123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, response_id INT NOT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_B6BD307FFBF32840 (response_id), INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_user (id INT AUTO_INCREMENT NOT NULL, message_id INT NOT NULL, user_id INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_24064D90537A1329 (message_id), INDEX IDX_24064D90A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFBF32840 FOREIGN KEY (response_id) REFERENCES response (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE message_user ADD CONSTRAINT FK_24064D90537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE message_user ADD CONSTRAINT FK_24064D90A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FFBF32840');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE message_user DROP FOREIGN KEY FK_24064D90537A1329');
        $this->addSql('ALTER TABLE message_user DROP FOREIGN KEY FK_24064D90A76ED395');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_user');
    }
}
