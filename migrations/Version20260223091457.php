<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260223091457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D37ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE color ADD symbole VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F45444ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F45447ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3C54C8C93');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3A76ED395');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D37ADA1FB5');
        $this->addSql('ALTER TABLE color DROP symbole');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F45444ACC9A20');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F45447ADA1FB5');
    }
}
