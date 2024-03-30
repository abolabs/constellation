// Copyright (C) 2023 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
import raFrenchMessages from "ra-language-french";

const frenchMessages = {
  ...raFrenchMessages,
  ra: {
    ...raFrenchMessages?.ra,
    action: {
      ...raFrenchMessages?.ra?.action,
      show: "Détail",
      create: "Créer",
      send: "Envoyer",
      impact_detection: "Détection d'impact",
      import: "Importer",
    },
  },
  resources: {
    account: {
      name: "Account",
      fields: {
        name: "Nom complet",
        email: "Email",
      },
    },
    applications: {
      name: "Applications",
      fields: {
        id: "Id",
        name: "Nom",
        team_id: "Equipe",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
      },
    },
    "application-mapping": {
      // not a dedicated resources, but needed for the breadcrumd
      name: "Cartographie application",
    },
    "by-app": {
      // not a dedicated resources, but needed for the breadcrumd
      name: "Applications",
    },
    "services-by-app": {
      // not a dedicated resources, but needed for the breadcrumd
      name: "Services",
    },
    "by-hosting": {
      // not a dedicated resources, but needed for the breadcrumd
      name: "Hébergments",
    },
    import: {
      // not a dedicated resources, but needed for the breadcrumd
      name: "Importer",
    },
    service_instances: {
      name: "Instances de service",
      fields: {
        id: "Id",
        application_id: "Id application",
        application_name: "Application",
        service_version_id: "Version de service",
        service_name: "Service",
        service_id: "Service",
        service_version: "Version de service",
        environment_id: "Environnement",
        environment_name: "Environnement",
        hosting_id: "Hébergement",
        hosting_name: "Hébergement",
        url: "Url",
        role: "Rôle",
        statut: "Statut",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
        meta: "Meta données",
      },
    },
    environments: {
      name: "Environnements",
      fields: {
        id: "Id",
        name: "Environnement",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
      },
    },
    hosting_types: {
      name: "Types d'hébergement",
      fields: {
        id: "Id",
        name: "Type d'hébergement",
        description: "Description",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
      },
    },
    hostings: {
      name: "Hébergements",
      fields: {
        id: "Id",
        name: "Hébergement",
        hosting_type_id: "Type d'hébergement",
        hosting_type_name: "Type d'hébergement",
        localisation: "Localisation",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
        meta: "Meta données",
      },
    },
    teams: {
      name: "Equipes",
      fields: {
        id: "Id",
        name: "Equipe",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
      },
    },
    services: {
      name: "Services",
      fields: {
        id: "Id",
        name: "Service",
        team_id: "Equipe",
        git_repo: "Dépôt Git",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
        meta: "Meta données",
      },
    },
    service_versions: {
      name: "Versions de service",
      fields: {
        id: "Id",
        service_id: "Service",
        service_name: "Service",
        version: "version",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
      },
    },
    service_instance_dependencies: {
      name: "Dépendances de services",
      fields: {
        id: "Id",
        instance_application_id: "Application",
        instance_application_name: "Application",
        instance_id: "Id instance",
        instance_service_name: "Service",
        instance_dep_application_id: "Application de la dépendance",
        instance_dep_application_name: "Application de la dépendance",
        instance_dep_id: "Id dépendance",
        instance_dep_service_name: "Dépendance",
        level: "Niveau de dépendance",
        description: "Description",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
      },
    },
    roles: {
      name: "Rôles",
      fields: {
        id: "Id",
        name: "Rôle",
        permissions: "Permissions",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
      },
    },
    permissions: {
      name: "Permissions",
      fields: {
        id: "Id",
        name: "Permission",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
      },
    },
    users: {
      name: "Utilisateurs",
      fields: {
        id: "Id",
        name: "Nom",
        email: "email",
        roles: "roles",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
        meta: "Meta données",
      },
    },
    audits: {
      name: "Audits",
      fields: {
        user_type: "Type d'utilisateur",
        user_id: "Id utilisateur",
        user_name: "Nom utilisateur",
        event: "Evénement",
        auditable_type: "Auditable type",
        auditable_id: "Id audit",
        old_values: "Valeurs précédentes",
        new_values: "Nouvelles valeurs",
        url: "url",
        ip_address: "IP",
        user_agent: "User agent",
        tags: "tags",
        created_at: "Date de création",
        updated_at: "Date de mise à jour",
      },
    },
  },
  optional: "optionnel",
  Dependencies: "Dépendances",
  Dependency: "Dépendance",
  "Required by": "Requis par",
  "Remove dependency": "Supprimer la dépendance",
  "Are you sure you to remove #%{dep_id} - %{service_name} instance has dependency ?":
    "Êtes-vous sûr de vouloir supprimer l'instance #%{dep_id} - %{service_name} comme dépendance ?",
  "Service instance created": "Instance de service créée",
  "Add a new service instance": "Ajouter une nouvelle instance de service",
  "View more": "Voir plus",
  "Service dependency added": "Dépendance de service ajoutée",
  "Service dependency edited": "Dépendance de service modifiée",
  "Please select a dependency": "Merci de sélectionner une dépendance",
  "Please select a dependency level":
    "Merci de sélectionner un niveau de dépendance",
  "Add a service dependency": "Ajouter une dépendance de service",
  "Edit the dependency": "Editer la dépendance",
  minor: "mineur",
  major: "majeur",
  critic: "critique",
  level_description: {
    minor:
      "En cas d'indisponibilité : impact sur fonctionnalité(s) mineure(s) ou majeure(s) avec solution de contournement",
    major:
      "En cas d'indisponibilité : impact sur fonctionnalité(s) majeure(s) sans solution de contournement mais sans indisponibilité générale",
    critic:
      "En cas d'indisponibilité : impact de fonctionnalité(s) majeure(s) sans solution de contournement entrainant une indisponibilité générale de l'application",
  },
  "Instances per application": "Instances par application",
  "Please define a service name": "Merci de définir un nom de service",
  "Please define a git url": "Merci de définir une url pour le repo git",
  "Please select a team": "Merci de sélectionner une équipe",
  "Please select a service version":
    "Merci de sélectionner une version de service",
  "Please select an environment": "Merci de sélectionner un environnement",
  "Please select an hosting": "Merci de sélectionner un hébergement",
  "Please select a hosting type": "Merci de sélectionner un type d'hébergement",
  "Please select a hosting": "Merci de sélectionner un hébergement",
  "Please define a name": "Merci de définir un nom",
  "Please define a description": "Merci de définir une description",
  "Please select an application": "Merci de sélectionner une application",
  "Please select a service": "Merci de sélectionner un service",
  "Please define a hosting name": "Merci de définir un nom d'hébergement",
  "Please select at least one permission":
    "Merci de sélectionner une permission au minimum",
  "Please select at least one role": "Merci de sélectionner au moins un rôle",
  "Please define a version": "Merci de définir une version",
  "Please define a team name": "Merci de définir un nom d'équipe",
  "Please define a team manager": "Merci de définir un responsable d'équipe",
  Instances: "Instances",
  "Application mapping": "Cartographie Applicative",
  Inventory: "Inventaire",
  Admin: "Admin",
  Profile: "Profile",
  needs: "requière",
  "Internal error": "Erreur interne",
  Error: "Erreur",
  "Full name required": "Nom complet requis",
  "Please define an email": "Merci de saisir une adresse email",
  "Please define a password": "Merci de saisir un mot de passe",
  "Please enter your new password":
    "Merci de saisir votre nouveau mot de passe",
  "Please confirm the password": "Merci de confirmer le mot de passe",
  "Passwords must match": "Les mots de passe doivent correspondre",
  "Please enter your current password to confirm":
    "Merci de saisir votre mot de passe actuel afin de confirmer le changement.",
  "Confirm e-mail change by entering your current password":
    "Saisissez votre mot de passe actuel afin de confirmer le changement",
  Profil: "Profile",
  "Confirm your password": "Confirmer votre mot de passe",
  "Reset the password": "Réinitialiser le mot de passe",
  "Please define an environment name":
    "Merci de définir un nom d'environnement",
  "Use the contextual menu to access to the detail of each node.":
    "Utiliser le menu contextuel pour accéder au détail de chaque noeud.",
  "Left click 2s or right click": "Clic gauche 2s ou clic droit",
  Legend: "Legende",
  "Dependency level": "Niveau de dépendance",
  Filter: "Filtrer",
  "Mapping by app": "Cartographie par application",
  "Mapping by hosting": "Cartographie par hébergement",
  "Mapping by service": "Cartographie par service",
  "Invalid email or password": "Email ou mot de passe invalide",
  "Email Address": "Adresse e-mail",
  Password: "Mot de passe",
  "Forgot password?": "Mot de passe oublié ?",
  "Don't have an account?": "Pas de compte de compte ?",
  "Please contact your administrator to request an account.":
    "Merci de contacter votre administrateur pour demander un compte.",
  "Password reset!": "Mot de passe réinitialisé !",
  "New password": "Nouveau mot de passe",
  "Confirm password": "Confirmer le mot de passe",
  "Email sent!": "Email envoyé !",
  "Reset your password": "Réinitialiser votre mot de passe",
  "Enter the email to send the reset link.":
    "Entrer l'e-mail pour envoyer le lien de réinitialisation.",
  Dashboard: "Tableau de bord",
  "Service instances / Service": "Instances de services / Service",
  "New version": "Nouvelle version",
  "Version added": "Version ajoutée",
  "Application imported": "Application importée",
  "This instance has no dependencies.": "Cette instance n'a aucune dépendance.",
  "This instance is not required by any other instance.": "Cette instance n'est requise par aucune autre instance.",
};

export default frenchMessages;
