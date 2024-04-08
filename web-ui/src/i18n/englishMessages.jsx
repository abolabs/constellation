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
import raEnglishMessages from "ra-language-english";

const englishMessages = {
  ...raEnglishMessages,
  ra: {
    ...raEnglishMessages?.ra,
    action: {
      ...raEnglishMessages?.ra?.action,
      show: "Detail",
      create: "Create",
      send: "Send",
      impact_detection: "Impact detection",
      import: "Import",
    },
  },
  resources: {
    account: {
      name: "Account",
      fields: {
        name: "Full name",
        email: "Email",
      },
    },
    applications: {
      name: "Applications",
      fields: {
        id: "Id",
        name: "Name",
        team_id: "Team",
        created_at: "Created at",
        updated_at: "Updated at",
      },
    },
    "application-mapping": {
      // not a dedicated resources, but needed for the breadcrumd
      name: "Application Mapping",
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
      name: "Hostings",
    },
    import: {
      // not a dedicated resources, but needed for the breadcrumd
      name: "Import",
    },
    service_instances: {
      name: "Service instances",
      fields: {
        id: "Id",
        application_id: "Application Id",
        application_name: "Application",
        service_version_id: "Service version",
        service_name: "Service",
        service_id: "Service",
        service_version: "Service version",
        environment_id: "Environment",
        environment_name: "Environment",
        hosting_id: "Hosting",
        hosting_name: "Hosting",
        url: "Url",
        role: "Role",
        statut: "Status",
        created_at: "Created at",
        updated_at: "Updated at",
        meta: "Meta data",
      },
    },
    environments: {
      name: "Environments",
      fields: {
        id: "Id",
        name: "Environment",
        created_at: "Created at",
        updated_at: "Updated at",
      },
    },
    hosting_types: {
      name: "Hosting types",
      fields: {
        id: "Id",
        name: "Hosting type",
        description: "Description",
        created_at: "Created at",
        updated_at: "Updated at",
      },
    },
    hostings: {
      name: "Hostings",
      fields: {
        id: "Id",
        name: "Hosting",
        hosting_type_id: "Hosting type",
        hosting_type_name: "Hosting type",
        localisation: "Location",
        created_at: "Created at",
        updated_at: "Updated at",
        meta: "Meta data",
      },
    },
    teams: {
      name: "Teams",
      fields: {
        id: "Id",
        name: "Team",
        created_at: "Created at",
        updated_at: "Updated at",
      },
    },
    services: {
      name: "Services",
      fields: {
        id: "Id",
        name: "Service",
        team_id: "Team",
        git_repo: "Git repository",
        created_at: "Created at",
        updated_at: "Updated at",
        meta: "Meta data",
      },
    },
    service_versions: {
      name: "Service versions",
      fields: {
        id: "Id",
        service_id: "Service",
        service_name: "Service",
        version: "Version",
        created_at: "Created at",
        updated_at: "Updated at",
      },
    },
    service_instance_dependencies: {
      name: "Service dependencies",
      fields: {
        id: "Id",
        instance_application_id: "Application",
        instance_application_name: "Application",
        instance_id: "Instance Id",
        instance_service_name: "Service",
        instance_dep_application_id: "Dependency app",
        instance_dep_application_name: "Dependency app",
        instance_dep_id: "Dependency Id",
        instance_dep_service_name: "Dependency",
        level: "Dependency level",
        description: "Description",
        created_at: "Created at",
        updated_at: "Updated at",
      },
    },
    roles: {
      name: "Roles",
      fields: {
        id: "Id",
        name: "Role",
        permissions: "Permissions",
        created_at: "Created at",
        updated_at: "Updated at",
      },
    },
    permissions: {
      name: "Permissions",
      fields: {
        id: "Id",
        name: "Permission",
        created_at: "Created at",
        updated_at: "Updated at",
      },
    },
    users: {
      name: "Users",
      fields: {
        id: "Id",
        name: "Name",
        email: "email",
        roles: "roles",
        created_at: "Created at",
        updated_at: "Updated at",
        meta: "Meta data",
      },
    },
    audits: {
      name: "Audits",
      fields: {
        user_type: "User type",
        user_id: "User Id",
        user_name: "User name",
        event: "Event",
        auditable_type: "Auditable type",
        auditable_id: "Auditable Id",
        old_values: "Old values",
        new_values: "New values",
        url: "url",
        ip_address: "IP",
        user_agent: "User agent",
        tags: "tags",
        created_at: "Created at",
        updated_at: "Updated at",
      },
    },
  },
  optional: "optional",
  Dependencies: "Dependencies",
  Dependency: "Dependency",
  "Required by": "Required by",
  "Remove dependency": "Remove dependency",
  "Are you sure you to remove #%{dep_id} - %{service_name} instance has dependency ?":
    "Are you sure you to remove #%{dep_id} - %{service_name} instance has dependency ?",
  "Service instance created": "Service instance created",
  "Add a new service instance": "Add a new service instance",
  "View more": "View more",
  "Service dependency added": "Service dependency added",
  "Service dependency edited": "Service dependency edited",
  "Please select a dependency": "Please select a dependency",
  "Please select a dependency level": "Please select a dependency level",
  "Add a service dependency": "Add a service dependency",
  "Edit the dependency": "Edit the dependency",
  minor: "minor",
  major: "major",
  critic: "critic",
  level_description: {
    minor:
      "In the event of unavailability: impact on minor or major functionality (s) with workaround",
    major:
      "In the event of unavailability: impact on major feature (s) without workaround but without general unavailability",
    critic:
      "In the event of unavailability: impact of major functionality (s) without a workaround resulting in general unavailability of the application",
  },
  "Instances per application": "Instances per application",
  "Please define a service name": "Please define a service name",
  "Please define a git url": "Please define a git url",
  "Please select a team": "Please select a team",
  "Please select a service version": "Please select a service version",
  "Please select an environment": "Please select an environment",
  "Please select an hosting": "Please select an hosting",
  "Please select a hosting type": "Please select a hosting type",
  "Please select a hosting": "Please select a hosting",
  "Please define a name": "Please define a name",
  "Please define a description": "Please define a description",
  "Please select an application": "Please select an application",
  "Please select a service": "Please select a service",
  "Please define a hosting name": "Please define a hosting name",
  "Please select at least one permission":
    "Please select at least one permission",
  "Please select at least one role": "Please select at least one role",
  "Please define a version": "Please define a version",
  "Please define a team name": "Please define a team name",
  "Please define a team manager": "Please define a team manager",
  Instances: "Instances",
  "Application mapping": "Application mapping",
  Inventory: "Inventory",
  Admin: "Admin",
  Profile: "Profile",
  "Profile edition is disabled": "Profile edition is disabled",
  needs: "needs",
  "Internal error": "Internal error",
  Error: "Error",
  "Full name required": "Full name required",
  "Please define an email": "Please define an email",
  "Please define a password": "Please define a password",
  "Please enter your new password": "Please enter your new password",
  "Please confirm the password": "Please confirm the password",
  "Passwords must match": "Passwords must match",
  "Please enter your current password to confirm":
    "Please enter your current password to confirm",
  "Confirm e-mail change by entering your current password":
    "Confirm e-mail change by entering your current password",
  "Confirm your password": "Confirm your password",
  "Reset the password": "Reset the password",
  "Please define an environment name": "Please define an environment name",
  "Use the contextual menu to access to the detail of each node.":
    "Use the contextual menu to access to the detail of each node.",
  "Left click 2s or right click": "Left click 2s or right click",
  Legend: "Legend",
  "Dependency level": "Dependency level",
  Filter: "Filter",
  "Mapping by app": "Mapping by app",
  "Mapping by hosting": "Mapping by hosting",
  "Mapping by service": "Mapping by service",
  "Invalid email or password": "Invalid email or password",
  "Email Address": "Email Address",
  Password: "Password",
  "Forgot password?": "Forgot password?",
  "Don't have an account?": "Don't have an account?",
  "Please contact your administrator to request an account.":
    "Please contact your administrator to request an account.",
  "Password reset!": "Password reset!",
  "New password": "New password",
  "Confirm password": "Confirm password",
  "Email sent!": "Email sent!",
  "Reset your password": "Reset your password",
  "Enter the email to send the reset link.":
    "Enter the email to send the reset link.",
  Dashboard: "Dashboard",
  "Service instances / Service": "Service instances / Service",
  "New version": "New version",
  "Version added": "Version added",
  "Application imported": "Application imported",
  "This instance has no dependencies.": "This instance has no dependencies.",
  "This instance is not required by any other instance.": "This instance is not required by any other instance.",
  "Report a bug": "Report a bug",
};

export default englishMessages;
