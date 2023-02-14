<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207094109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card ADD link_url VARCHAR(255) DEFAULT NULL, ADD desc_image VARCHAR(255) DEFAULT NULL, DROP linkUrl, DROP descImage, CHANGE imageUrl image_url VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card ADD linkUrl VARCHAR(255) DEFAULT NULL, ADD descImage VARCHAR(255) DEFAULT NULL, DROP link_url, DROP desc_image, CHANGE image_url imageUrl VARCHAR(255) NOT NULL');
    }
}
