<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211113524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modification de la colonne user_id pour la rendre NOT NULL';
    }

    public function up(Schema $schema): void
    {
        // Supprime la contrainte de clé étrangère
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBA76ED395');
        
        // Modifie la colonne user_id pour la rendre NOT NULL
        $this->addSql('ALTER TABLE abonnement CHANGE user_id user_id INT NOT NULL');
        
        // Réinstalle la contrainte de clé étrangère
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // Supprime la contrainte de clé étrangère
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBA76ED395');
        
        // Réinitialise la colonne user_id à son état précédent (NULL autorisé)
        $this->addSql('ALTER TABLE abonnement CHANGE user_id user_id INT DEFAULT NULL');
        
        // Réinstalle la contrainte de clé étrangère
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}

