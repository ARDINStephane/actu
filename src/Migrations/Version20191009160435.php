<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009160435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode CHANGE number number INT NOT NULL, CHANGE images images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE year year VARCHAR(255) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE note note VARCHAR(255) DEFAULT NULL, CHANGE episode_show episode_show VARCHAR(255) DEFAULT NULL, CHANGE seen seen TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DDAA1CDA2B36786B ON episode (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DDAA1CDA96901F54 ON episode (number)');
        $this->addSql('ALTER TABLE serie CHANGE alias alias LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE images images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE year year VARCHAR(255) DEFAULT NULL, CHANGE origin origin VARCHAR(255) DEFAULT NULL, CHANGE genre genre LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE number_of_seasons number_of_seasons VARCHAR(255) DEFAULT NULL, CHANGE number_of_episodes number_of_episodes VARCHAR(255) DEFAULT NULL, CHANGE last_episode last_episode VARCHAR(255) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE note note VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE serie_show serie_show VARCHAR(255) DEFAULT NULL, CHANGE seen seen TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA3A93342B36786B ON serie (title)');
        $this->addSql('ALTER TABLE season CHANGE number number INT NOT NULL, CHANGE images images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE year year VARCHAR(255) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE note note VARCHAR(255) DEFAULT NULL, CHANGE season_show season_show VARCHAR(255) DEFAULT NULL, CHANGE seen seen TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F0E45BA996901F54 ON season (number)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_DDAA1CDA2B36786B ON episode');
        $this->addSql('DROP INDEX UNIQ_DDAA1CDA96901F54 ON episode');
        $this->addSql('ALTER TABLE episode CHANGE number number VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE images images LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE year year VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE description description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE note note VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE episode_show episode_show VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE seen seen TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_F0E45BA996901F54 ON season');
        $this->addSql('ALTER TABLE season CHANGE number number VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE images images LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE year year VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE description description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE note note VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE season_show season_show VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE seen seen TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_AA3A93342B36786B ON serie');
        $this->addSql('ALTER TABLE serie CHANGE alias alias LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE images images LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE year year VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE origin origin VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE genre genre LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE number_of_seasons number_of_seasons VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE number_of_episodes number_of_episodes VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE last_episode last_episode VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE description description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE note note VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE status status VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE serie_show serie_show VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE seen seen TINYINT(1) NOT NULL');
    }
}
