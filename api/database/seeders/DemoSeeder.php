<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
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

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Environment;
use App\Models\Hosting;
use App\Models\Service;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use App\Models\ServiceVersion;
use App\Models\Team;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itTeam = Team::create([
            'name' => 'IT team',
            'manager' => 'manager name',
        ]);

        $envs = [
            'Production' => Environment::where('name', 'Production')->first()->id,
            'Staging' => Environment::where('name', 'Staging')->first()->id,
            'Dev' => Environment::where('name', 'Dev')->first()->id,
        ];

        // Application - Microsoft 365
        $microsoft365 = Application::factory()->create([
            'name' => 'Microsoft 365',
            'team_id' => $itTeam->id
        ]);

        $microsoftSaasHosting = Hosting::factory()->create([
            'name' => 'Microsoft365 saas',
            'hosting_type_id' => 4,
        ]);

        // Microsoft Entra Connect V2
        $microsoftEntraConnect = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Microsoft Entra Connect V2',
            'git_repo' => 'https://learn.microsoft.com/fr-fr/entra/identity/hybrid/connect/whatis-azure-ad-connect',
        ]);
        $microsoftEntraConnectVersion = ServiceVersion::create([
            'service_id' => $microsoftEntraConnect->id,
            'version' => 'saas',
        ]);
        $microsoftEntraConnectInstance = ServiceInstance::factory()->create([
            'application_id' => $microsoft365->id,
            'service_version_id' => $microsoftEntraConnectVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $microsoftSaasHosting->id,
        ]);

        // oneDrive
        $oneDrive = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'OneDrive',
            'git_repo' => 'https://www.microsoft.com/fr-fr/microsoft-365/onedrive/online-cloud-storage',
        ]);
        $oneDriveVersion = ServiceVersion::create([
            'service_id' => $oneDrive->id,
            'version' => 'saas',
        ]);
        $oneDriveInstance = ServiceInstance::factory()->create([
            'application_id' => $microsoft365->id,
            'service_version_id' => $oneDriveVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $microsoftSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $oneDriveInstance->id,
            'instance_dep_id' => $microsoftEntraConnectInstance->id,
            'level' => 3
        ]);

        // Office365
        $office365 = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Office365',
            'git_repo' => 'https://www.microsoft.com/fr-fr/microsoft-365',
        ]);
        $office365Version = ServiceVersion::create([
            'service_id' => $office365->id,
            'version' => 'saas',
        ]);
        $office365Instance = ServiceInstance::factory()->create([
            'application_id' => $microsoft365->id,
            'service_version_id' => $office365Version->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $microsoftSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $office365Instance->id,
            'instance_dep_id' => $microsoftEntraConnectInstance->id,
            'level' => 3
        ]);

        // SharePoint
        $sharePoint = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'SharePoint',
            'git_repo' => 'https://www.microsoft.com/fr-fr/microsoft-365/sharepoint/collaboration',
        ]);
        $sharePointVersion = ServiceVersion::create([
            'service_id' => $sharePoint->id,
            'version' => 'saas',
        ]);
        $sharePointInstance = ServiceInstance::factory()->create([
            'application_id' => $microsoft365->id,
            'service_version_id' => $sharePointVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $microsoftSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $sharePointInstance->id,
            'instance_dep_id' => $microsoftEntraConnectInstance->id,
            'level' => 3
        ]);

        // Microsoft Teams
        $microsoftTeams = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Microsoft Teams',
            'git_repo' => 'https://www.microsoft.com/fr-fr/microsoft-teams/group-chat-software',
        ]);
        $microsoftTeamsVersion = ServiceVersion::create([
            'service_id' => $microsoftTeams->id,
            'version' => 'saas',
        ]);
        $microsoftTeamsInstance = ServiceInstance::factory()->create([
            'application_id' => $microsoft365->id,
            'service_version_id' => $microsoftTeamsVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $microsoftSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $microsoftTeamsInstance->id,
            'instance_dep_id' => $microsoftEntraConnectInstance->id,
            'level' => 3
        ]);

        // Microsoft Outlook 365
        $microsoftOutlook365 = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Microsoft Outlook 365',
            'git_repo' => 'https://www.microsoft.com/fr-fr/microsoft-365/outlook/email-and-calendar-software-microsoft-outlook',
        ]);
        $microsoftOutlook365Version = ServiceVersion::create([
            'service_id' => $microsoftOutlook365->id,
            'version' => 'saas',
        ]);
        $microsoftOutlook365Instance = ServiceInstance::factory()->create([
            'application_id' => $microsoft365->id,
            'service_version_id' => $microsoftOutlook365Version->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $microsoftSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $microsoftOutlook365Instance->id,
            'instance_dep_id' => $microsoftEntraConnectInstance->id,
            'level' => 3
        ]);

        // Application - Odoo (ERP)
        $odooOnline = Application::factory()->create([
            'name' => 'Odoo Online',
            'team_id' => $itTeam->id
        ]);

        $odooOnlineSaasHosting = Hosting::factory()->create([
            'name' => 'Odoo Online saas',
            'hosting_type_id' => 4,
        ]);

        // Odoo Email Marketing
        $odooEmailMarketing = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Email Marketing',
            'git_repo' => 'https://www.odoo.com/en_GB/app/email-marketing',
        ]);
        $odooEmailMarketingVersion = ServiceVersion::create([
            'service_id' => $odooEmailMarketing->id,
            'version' => 'saas',
        ]);
        $odooEmailMarketingInstance = ServiceInstance::factory()->create([
            'application_id' => $odooOnline->id,
            'service_version_id' => $odooEmailMarketingVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $odooOnlineSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $odooEmailMarketingInstance->id,
            'instance_dep_id' => $microsoftOutlook365Instance->id,
        ]);

        // Odoo Time off
        $odooTimeOff = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Time off',
            'git_repo' => 'https://www.odoo.com/en_GB/app/email-marketing',
        ]);
        $odooTimeOffVersion = ServiceVersion::create([
            'service_id' => $odooTimeOff->id,
            'version' => 'saas',
        ]);
        $odooTimeOffInstance = ServiceInstance::factory()->create([
            'application_id' => $odooOnline->id,
            'service_version_id' => $odooTimeOffVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $odooOnlineSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $odooTimeOffInstance->id,
            'instance_dep_id' => $microsoftOutlook365Instance->id,
        ]);

        // Odoo CRM
        $odooCRM = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'CRM',
            'git_repo' => 'https://www.odoo.com/en_GB/app/email-marketing',
        ]);
        $odooCRMVersion = ServiceVersion::create([
            'service_id' => $odooCRM->id,
            'version' => 'saas',
        ]);
        $odooCRMInstance = ServiceInstance::factory()->create([
            'application_id' => $odooOnline->id,
            'service_version_id' => $odooCRMVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $odooOnlineSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $odooCRMInstance->id,
            'instance_dep_id' => $microsoftOutlook365Instance->id,
        ]);

        // Odoo Accounting
        $odooAccounting = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Accounting',
            'git_repo' => 'https://www.odoo.com/en_GB/app/email-marketing',
        ]);
        $odooAccountingVersion = ServiceVersion::create([
            'service_id' => $odooAccounting->id,
            'version' => 'saas',
        ]);
        $odooAccountingInstance = ServiceInstance::factory()->create([
            'application_id' => $odooOnline->id,
            'service_version_id' => $odooAccountingVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $odooOnlineSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $odooAccountingInstance->id,
            'instance_dep_id' => $odooTimeOffInstance->id,
        ]);

        // Application - Jira
        $jira = Application::factory()->create([
            'name' => 'Jira',
            'team_id' => $itTeam->id
        ]);

        $jiraSaasHosting = Hosting::factory()->create([
            'name' => 'Jira saas',
            'hosting_type_id' => 4,
        ]);

        // Jira IT Support
        $jiraItSupport = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'IT Support',
            'git_repo' => 'https://www.atlassian.com/software/jira',
        ]);
        $jiraItSupportVersion = ServiceVersion::create([
            'service_id' => $jiraItSupport->id,
            'version' => 'saas',
        ]);
        $jiraItSupportInstance = ServiceInstance::factory()->create([
            'application_id' => $jira->id,
            'service_version_id' => $jiraItSupportVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $jiraSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $jiraItSupportInstance->id,
            'instance_dep_id' => $microsoftOutlook365Instance->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $jiraItSupportInstance->id,
            'instance_dep_id' => $microsoftEntraConnectInstance->id,
            'level' => 3
        ]);

        // Jira IT Operations
        $jiraItOperation = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'IT Operations',
            'git_repo' => 'https://www.atlassian.com/software/jira',
        ]);
        $jiraItOperationVersion = ServiceVersion::create([
            'service_id' => $jiraItOperation->id,
            'version' => 'saas',
        ]);
        $jiraItOperationInstance = ServiceInstance::factory()->create([
            'application_id' => $jira->id,
            'service_version_id' => $jiraItOperationVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $jiraSaasHosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $jiraItOperationInstance->id,
            'instance_dep_id' => $microsoftEntraConnectInstance->id,
            'level' => 3
        ]);

        // Self developped tools

        // Application - Extranet
        $extranet = Application::factory()->create([
            'name' => 'Customer Extranet',
            'team_id' => $itTeam->id
        ]);

        $extranetFront1Hosting = Hosting::factory()->create([
            'name' => 'extranet-front-1',
            'hosting_type_id' => 2,
        ]);
        $extranetFront2Hosting = Hosting::factory()->create([
            'name' => 'extranet-front-2',
            'hosting_type_id' => 2,
        ]);
        $extranetAPI1Hosting = Hosting::factory()->create([
            'name' => 'extranet-api-1',
            'hosting_type_id' => 2,
        ]);
        $extranetAPI2Hosting = Hosting::factory()->create([
            'name' => 'extranet-api-1',
            'hosting_type_id' => 2,
        ]);
        $extranetDB1Hosting = Hosting::factory()->create([
            'name' => 'extranet-db-1',
            'hosting_type_id' => 2,
        ]);
        $extranetDB2Hosting = Hosting::factory()->create([
            'name' => 'extranet-db-2',
            'hosting_type_id' => 2,
        ]);

        // Extranet - Proxy
        $HAProxy = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'HAProxy',
            'git_repo' => 'https://github.com/haproxy/haproxy',
        ]);
        $HAProxyVersion = ServiceVersion::create([
            'service_id' => $HAProxy->id,
            'version' => 'latest',
        ]);
        // Extranet - Front Proxy
        $extranetFrontProxyInstance1 = ServiceInstance::factory()->create([
            'application_id' => $extranet->id,
            'service_version_id' => $HAProxyVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $extranetFront1Hosting->id,
        ]);

        // Extranet - Front
        $extranetFront = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Front-end Extranet',
        ]);
        $extranetFrontVersion = ServiceVersion::create([
            'service_id' => $extranetFront->id,
            'version' => 'latest',
        ]);
        $extranetFrontInstance1 = ServiceInstance::factory()->create([
            'application_id' => $extranet->id,
            'service_version_id' => $extranetFrontVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $extranetFront1Hosting->id,
        ]);
        $extranetFrontInstance2 = ServiceInstance::factory()->create([
            'application_id' => $extranet->id,
            'service_version_id' => $extranetFrontVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $extranetFront2Hosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extranetFrontInstance1->id,
            'instance_dep_id' => $extranetFrontProxyInstance1->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extranetFrontInstance2->id,
            'instance_dep_id' => $extranetFrontProxyInstance1->id,
        ]);

        // Extranet - API Proxy
        $extranetAPIProxyInstance1 = ServiceInstance::factory()->create([
            'application_id' => $extranet->id,
            'service_version_id' => $HAProxyVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $extranetAPI1Hosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extranetFrontInstance1->id,
            'instance_dep_id' => $extranetAPIProxyInstance1->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extranetFrontInstance2->id,
            'instance_dep_id' => $extranetAPIProxyInstance1->id,
        ]);

        // Extranet - API
        $extranetAPI = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Extranet API',
        ]);
        $extranetAPIVersion = ServiceVersion::create([
            'service_id' => $extranetAPI->id,
            'version' => 'latest',
        ]);
        $extranetAPIInstance1 = ServiceInstance::factory()->create([
            'application_id' => $extranet->id,
            'service_version_id' => $extranetAPIVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $extranetAPI1Hosting->id,
        ]);
        $extranetAPIInstance2 = ServiceInstance::factory()->create([
            'application_id' => $extranet->id,
            'service_version_id' => $extranetAPIVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $extranetAPI2Hosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extranetAPIInstance1->id,
            'instance_dep_id' => $extranetAPIProxyInstance1->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extranetAPIInstance1->id,
            'instance_dep_id' => $microsoftOutlook365Instance->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extranetAPIInstance2->id,
            'instance_dep_id' => $microsoftOutlook365Instance->id,
        ]);

        // Extranet - Database
        $postgresql = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Postgresql',
        ]);
        $postgresqlVersion = ServiceVersion::create([
            'service_id' => $postgresql->id,
            'version' => '16.1',
        ]);
        $extraneDBMasterInstance = ServiceInstance::factory()->create([
            'application_id' => $extranet->id,
            'service_version_id' => $postgresqlVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $extranetDB1Hosting->id,
        ]);
        $extraneDBSlaveInstance = ServiceInstance::factory()->create([
            'application_id' => $extranet->id,
            'service_version_id' => $postgresqlVersion->id,
            'environment_id' => $envs['Production'],
            'statut' => 1,
            'hosting_id' => $extranetDB2Hosting->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extraneDBMasterInstance->id,
            'instance_dep_id' => $extraneDBSlaveInstance->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extranetAPIInstance1->id,
            'instance_dep_id' => $extraneDBMasterInstance->id,
        ]);
        ServiceInstanceDependencies::create([
            'instance_id' => $extranetAPIInstance2->id,
            'instance_dep_id' => $extraneDBMasterInstance->id,
        ]);
    }
}
