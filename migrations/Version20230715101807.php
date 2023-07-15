<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230715101807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, INDEX IDX_3E7B0BFBF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_user (id INT AUTO_INCREMENT NOT NULL, response_id INT NOT NULL, user_id INT NOT NULL, ad_id INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_2132DCD3FBF32840 (response_id), INDEX IDX_2132DCD3A76ED395 (user_id), INDEX IDX_2132DCD34F34D596 (ad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBF675F31B FOREIGN KEY (author_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE response_user ADD CONSTRAINT FK_2132DCD3FBF32840 FOREIGN KEY (response_id) REFERENCES response (id)');
        $this->addSql('ALTER TABLE response_user ADD CONSTRAINT FK_2132DCD3A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE response_user ADD CONSTRAINT FK_2132DCD34F34D596 FOREIGN KEY (ad_id) REFERENCES Ads (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFBF675F31B');
        $this->addSql('ALTER TABLE response_user DROP FOREIGN KEY FK_2132DCD3FBF32840');
        $this->addSql('ALTER TABLE response_user DROP FOREIGN KEY FK_2132DCD3A76ED395');
        $this->addSql('ALTER TABLE response_user DROP FOREIGN KEY FK_2132DCD34F34D596');
        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE response_user');
    }
}
