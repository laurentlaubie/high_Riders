<?php
declare(strict_types=1);
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210924125752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, spot_id INT DEFAULT NULL, event_id INT DEFAULT NULL, content LONGTEXT NOT NULL, rate SMALLINT DEFAULT NULL, image VARCHAR(2100) DEFAULT NULL, status SMALLINT DEFAULT 1 NOT NULL, label_type VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', published_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526C2DF1D37C (spot_id), INDEX IDX_9474526C71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contactus (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, spot_id INT DEFAULT NULL, departement_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(2100) NOT NULL, description LONGTEXT NOT NULL, opening_hours VARCHAR(50) DEFAULT NULL, closed_hours VARCHAR(50) DEFAULT NULL, difficulty SMALLINT DEFAULT NULL, date_event VARCHAR(50) NOT NULL, link VARCHAR(2100) DEFAULT NULL, price INT DEFAULT NULL, accessibility LONGTEXT DEFAULT NULL, participation_user INT DEFAULT NULL, e_like INT DEFAULT NULL, status SMALLINT DEFAULT 1 NOT NULL, type_event VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', published_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) DEFAULT NULL, INDEX IDX_3BAE0AA72DF1D37C (spot_id), INDEX IDX_3BAE0AA7CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_category (event_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_40A0F01171F7E88B (event_id), INDEX IDX_40A0F01112469DE2 (category_id), PRIMARY KEY(event_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, event_id INT DEFAULT NULL, status SMALLINT DEFAULT 1 NOT NULL, INDEX IDX_AB55E24FA76ED395 (user_id), INDEX IDX_AB55E24F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spot (id INT AUTO_INCREMENT NOT NULL, departement_id INT DEFAULT NULL, title VARCHAR(150) NOT NULL, image VARCHAR(2100) NOT NULL, description LONGTEXT NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, longitude INT DEFAULT NULL, latitude INT DEFAULT NULL, opening_hours VARCHAR(50) DEFAULT NULL, closed_hours VARCHAR(50) DEFAULT NULL, saison_date VARCHAR(50) DEFAULT NULL, numbers_users INT DEFAULT NULL, average_rating INT DEFAULT NULL, difficulty SMALLINT DEFAULT NULL, link VARCHAR(2100) DEFAULT NULL, price INT DEFAULT NULL, accessibility LONGTEXT DEFAULT NULL, s_like INT DEFAULT NULL, d_positif INT DEFAULT NULL, d_negatif INT DEFAULT NULL, track_number SMALLINT DEFAULT NULL, type_spot VARCHAR(50) NOT NULL, status SMALLINT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', published_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) DEFAULT NULL, INDEX IDX_B9327A73CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spot_category (spot_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_DE0BD82F2DF1D37C (spot_id), INDEX IDX_DE0BD82F12469DE2 (category_id), PRIMARY KEY(spot_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, pseudo VARCHAR(150) NOT NULL, avatar VARCHAR(2100) DEFAULT NULL, firstname VARCHAR(255) NOT NULL, presentation LONGTEXT DEFAULT NULL, city VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, equipement LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64986CC499D (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_category (user_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_E6C1FDC1A76ED395 (user_id), INDEX IDX_E6C1FDC112469DE2 (category_id), PRIMARY KEY(user_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C2DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA72DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE event_category ADD CONSTRAINT FK_40A0F01171F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_category ADD CONSTRAINT FK_40A0F01112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE spot ADD CONSTRAINT FK_B9327A73CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE spot_category ADD CONSTRAINT FK_DE0BD82F2DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spot_category ADD CONSTRAINT FK_DE0BD82F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT FK_E6C1FDC1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT FK_E6C1FDC112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_category DROP FOREIGN KEY FK_40A0F01112469DE2');
        $this->addSql('ALTER TABLE spot_category DROP FOREIGN KEY FK_DE0BD82F12469DE2');
        $this->addSql('ALTER TABLE user_category DROP FOREIGN KEY FK_E6C1FDC112469DE2');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7CCF9E01E');
        $this->addSql('ALTER TABLE spot DROP FOREIGN KEY FK_B9327A73CCF9E01E');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C71F7E88B');
        $this->addSql('ALTER TABLE event_category DROP FOREIGN KEY FK_40A0F01171F7E88B');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F71F7E88B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C2DF1D37C');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA72DF1D37C');
        $this->addSql('ALTER TABLE spot_category DROP FOREIGN KEY FK_DE0BD82F2DF1D37C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FA76ED395');
        $this->addSql('ALTER TABLE user_category DROP FOREIGN KEY FK_E6C1FDC1A76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE contactus');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_category');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE spot');
        $this->addSql('DROP TABLE spot_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_category');
    }
}
