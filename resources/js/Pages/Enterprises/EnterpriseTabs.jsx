import React from "react";
import {
    LayoutDashboard,
    Users,
    FileText,
    BarChart3,
    Settings,
} from "lucide-react";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs";
import { cn } from "@/lib/utils";
import { router } from "@inertiajs/react";
import EnterpriseDetails from "./Partials/EnterpriseDetails";
import EmployeeList from "./Partials/EmployeeList";
import DocumentList from "./Partials/DocumentList";
import EnterpriseAnalytics from "./Partials/EnterpriseAnalytics";
import EnterpriseActions from "./Partials/EnterpriseActions";

const iconMap = {
    LayoutDashboard,
    Users,
    FileText,
    BarChart3,
    Settings,
};

const EnterpriseTabs = ({
    enterprise,
    tabs = {},
    currentTab = "dashboard",
}) => {
    const handleTabChange = (value) => {
        router.visit(route("enterprises.show", enterprise.id), {
            data: { tab: value },
            preserveState: true,
            preserveScroll: true,
        });
    };

    const renderTabContent = (tabKey) => {
        switch (tabKey) {
            case "dashboard":
                return <EnterpriseDetails enterprise={enterprise} />;
            case "employees":
                return <EmployeeList employees={enterprise.employees} />;
            case "documents":
                return <DocumentList documents={enterprise.documents} />;
            case "analytics":
                return <EnterpriseAnalytics />;
            case "actions":
                return <EnterpriseActions />;
            default:
                return (
                    <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <p className="text-gray-500">Contenu non disponible.</p>
                    </div>
                );
        }
    };

    // Vérification de sécurité pour les tabs
    if (!tabs || Object.keys(tabs).length === 0) {
        return (
            <div className="min-h-screen font-sans">
                <div className="w-full border mt-3 p-6">
                    <p className="text-gray-500">Chargement des onglets...</p>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen">
            <div className="w-full border mt-3">
                <Tabs
                    value={currentTab}
                    onValueChange={handleTabChange}
                    className="w-full"
                >
                    <TabsList className="grid w-full grid-cols-5 rounded-lg shadow-sm px-0 h-auto border-gray-200">
                        {Object.entries(tabs).map(([key, tab]) => {
                            const IconComponent = iconMap[tab.icon];
                            return (
                                <TabsTrigger
                                    key={key}
                                    value={key}
                                    className={cn(
                                        "group flex flex-col bg-white items-center justify-center p-4 data-[state=active]:shadow-none data-[state=active]:bg-primary/5 data-[state=active]:border-b-2 data-[state=active]:border-primary data-[state=active]:text-primary transition-colors rounded-none",
                                        "text-gray-500 hover:text-primary hover:bg-primary/10"
                                    )}
                                >
                                    <IconComponent className="h-5 w-5 mb-2 text-gray-400 group-hover:text-primary group-data-[state=active]:text-primary transition-colors" />
                                    <span className="text-sm font-medium text-gray-500 group-hover:text-primary group-data-[state=active]:text-primary transition-colors">
                                        {tab.label}
                                    </span>
                                </TabsTrigger>
                            );
                        })}
                    </TabsList>

                    {Object.keys(tabs).map((tabKey) => (
                        <TabsContent key={tabKey} value={tabKey}>
                            {renderTabContent(tabKey)}
                        </TabsContent>
                    ))}
                </Tabs>
            </div>
        </div>
    );
};

export default EnterpriseTabs;
