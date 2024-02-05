<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231230131255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, denom VARCHAR(255) NOT NULL, annee INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, type_code VARCHAR(255) NOT NULL, annee_id INT NOT NULL, titre VARCHAR(255) NOT NULL, utitre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, date_add DATETIME NOT NULL, INDEX IDX_23A0E66A01AF590 (type_code), INDEX IDX_23A0E66543EC5F0 (annee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attachment (id INT AUTO_INCREMENT NOT NULL, article_files_id INT DEFAULT NULL, article_images_id INT DEFAULT NULL, article_images_gallery_id INT DEFAULT NULL, original_filename VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, taille INT NOT NULL, INDEX IDX_795FD9BBF60EAF44 (article_files_id), INDEX IDX_795FD9BBE7A55C1 (article_images_id), INDEX IDX_795FD9BB7C5AF6FD (article_images_gallery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A01AF590 FOREIGN KEY (type_code) REFERENCES type (code)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66543EC5F0 FOREIGN KEY (annee_id) REFERENCES archive (id)');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BBF60EAF44 FOREIGN KEY (article_files_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BBE7A55C1 FOREIGN KEY (article_images_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BB7C5AF6FD FOREIGN KEY (article_images_gallery_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A01AF590');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66543EC5F0');
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BBF60EAF44');
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BBE7A55C1');
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BB7C5AF6FD');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
