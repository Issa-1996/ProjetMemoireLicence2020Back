<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413104140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE epargne (id INT AUTO_INCREMENT NOT NULL, montant VARCHAR(255) NOT NULL, interet VARCHAR(255) NOT NULL, date_epargne DATE NOT NULL, archivage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gerant (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tontine (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, session VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, archivage TINYINT(1) NOT NULL, date_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour (id INT AUTO_INCREMENT NOT NULL, tontine_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_6AD1F969DEB5C9FD (tontine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour_epargne (tour_id INT NOT NULL, epargne_id INT NOT NULL, INDEX IDX_E1700CCD15ED8D43 (tour_id), INDEX IDX_E1700CCDE55AE86D (epargne_id), PRIMARY KEY(tour_id, epargne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tresorier (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profil_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, archivage TINYINT(1) NOT NULL, genre VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, cni VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, avatar LONGBLOB NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tontine (user_id INT NOT NULL, tontine_id INT NOT NULL, INDEX IDX_671B5575A76ED395 (user_id), INDEX IDX_671B5575DEB5C9FD (tontine_id), PRIMARY KEY(user_id, tontine_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tour (user_id INT NOT NULL, tour_id INT NOT NULL, INDEX IDX_1050B5A0A76ED395 (user_id), INDEX IDX_1050B5A015ED8D43 (tour_id), PRIMARY KEY(user_id, tour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gerant ADD CONSTRAINT FK_D1D45C70BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tour ADD CONSTRAINT FK_6AD1F969DEB5C9FD FOREIGN KEY (tontine_id) REFERENCES tontine (id)');
        $this->addSql('ALTER TABLE tour_epargne ADD CONSTRAINT FK_E1700CCD15ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tour_epargne ADD CONSTRAINT FK_E1700CCDE55AE86D FOREIGN KEY (epargne_id) REFERENCES epargne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tresorier ADD CONSTRAINT FK_CAD8FB61BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE user_tontine ADD CONSTRAINT FK_671B5575A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tontine ADD CONSTRAINT FK_671B5575DEB5C9FD FOREIGN KEY (tontine_id) REFERENCES tontine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tour ADD CONSTRAINT FK_1050B5A0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tour ADD CONSTRAINT FK_1050B5A015ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tour_epargne DROP FOREIGN KEY FK_E1700CCDE55AE86D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('ALTER TABLE tour DROP FOREIGN KEY FK_6AD1F969DEB5C9FD');
        $this->addSql('ALTER TABLE user_tontine DROP FOREIGN KEY FK_671B5575DEB5C9FD');
        $this->addSql('ALTER TABLE tour_epargne DROP FOREIGN KEY FK_E1700CCD15ED8D43');
        $this->addSql('ALTER TABLE user_tour DROP FOREIGN KEY FK_1050B5A015ED8D43');
        $this->addSql('ALTER TABLE gerant DROP FOREIGN KEY FK_D1D45C70BF396750');
        $this->addSql('ALTER TABLE tresorier DROP FOREIGN KEY FK_CAD8FB61BF396750');
        $this->addSql('ALTER TABLE user_tontine DROP FOREIGN KEY FK_671B5575A76ED395');
        $this->addSql('ALTER TABLE user_tour DROP FOREIGN KEY FK_1050B5A0A76ED395');
        $this->addSql('DROP TABLE epargne');
        $this->addSql('DROP TABLE gerant');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE tontine');
        $this->addSql('DROP TABLE tour');
        $this->addSql('DROP TABLE tour_epargne');
        $this->addSql('DROP TABLE tresorier');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_tontine');
        $this->addSql('DROP TABLE user_tour');
    }
}
