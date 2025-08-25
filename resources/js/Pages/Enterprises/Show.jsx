import { Avatar, AvatarImage, AvatarFallback } from "@/Components/ui/avatar";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs";
import { cn } from "@/lib/utils";
import { Link, router } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import {
    LayoutDashboard,
    Users,
    FileText,
    BarChart3,
    Settings,
    Camera,
    Edit,
    Megaphone,
    CheckCircle,
    AlertCircle,
    X,
    BanIcon,
    HomeIcon,
} from "lucide-react";
import EnterpriseDetails from "./Partials/EnterpriseDetails";
import EmployeeList from "./Partials/EmployeeList";
import DocumentList from "./Partials/DocumentList";
import EnterpriseAnalytics from "./Partials/EnterpriseAnalytics";
import EnterpriseActions from "./Partials/EnterpriseActions";
import StatusBadge from "@/Components/StatusBadge";

const iconMap = {
    LayoutDashboard,
    Users,
    FileText,
    BarChart3,
    Settings,
};

export default function EnterpriseShow({
    auth,
    enterprise,
    tabs,
    currentTab,
    employees,
}) {
    const getStatusColor = (status) => {
        switch (status) {
            case "active":
                return "bg-emerald-500";
            case "pending":
                return "bg-amber-500";
            case "inactive":
                return "bg-gray-500";
            case "suspended":
                return "bg-red-500";
            default:
                return "bg-gray-500";
        }
    };

    const getStatusIcon = (status) => {
        switch (status) {
            case "active":
                return <CheckCircle className="h-4 w-4" />;
            case "pending":
                return <AlertCircle className="h-4 w-4" />;
            case "inactive":
                return <X className="h-4 w-4" />;
            case "suspended":
                return <BanIcon className="h-4 w-4" />;
            default:
                return <AlertCircle className="h-4 w-4" />;
        }
    };

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
                return <EmployeeList employees={employees} />;
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

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title={`Entreprise - ${enterprise.name}`} />

            <div className="min-h-screen bg-gray-50">
                {/* Profile Information Section */}
                <div className="relative px-6 pb-6 bg-primary/30 mt-12 pt-12">
                    {/* Avatar - Overlapping the cover */}
                    <div className="relative -mt-20 mb-6 flex items-center justify-between">
                        <div className="w-32 h-32 rounded-2xl overflow-hidden">
                            <Avatar className="w-full h-full border-2 border-primary/30">
                                <AvatarImage
                                    src={enterprise.logo}
                                    alt={enterprise.name}
                                />
                                <AvatarFallback className="text-2xl font-bold bg-gray-100 text-gray-600">
                                    {enterprise.name
                                        .substring(0, 2)
                                        .toUpperCase()}
                                </AvatarFallback>
                            </Avatar>
                        </div>
                        {/* Status Badge */}
                        <div>
                            <StatusBadge
                                status={enterprise.status}
                                filled={true}
                            />
                        </div>
                    </div>

                    {/* Enterprise Info and Action Buttons */}
                    <div className="flex items-start justify-between mb-6">
                        <div className="flex-1">
                            <h1 className="text-3xl font-bold text-gray-900 mb-2">
                                {enterprise.name}
                            </h1>
                            <div className="flex items-center gap-4 text-gray-600 mb-3">
                                <span className="text-sm">
                                    {enterprise.members?.length || 0} employés •{" "}
                                    {enterprise.departments?.length || 0}{" "}
                                    départements
                                </span>
                            </div>
                            {/* Follower avatars placeholder */}
                            <div className="flex -space-x-2">
                                {[1, 2, 3, 4, 5].map((i) => (
                                    <div
                                        key={i}
                                        className="w-8 h-8 rounded-full bg-gray-300 border-2 border-white"
                                    ></div>
                                ))}
                            </div>
                        </div>

                        {/* Action Buttons */}
                        <div className="flex gap-3">
                            <Link
                                href={route("dashboard")}
                                className="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-all duration-300 shadow-md"
                            >
                                <HomeIcon className="h-4 w-4" />
                                <span className="text-sm font-medium">
                                    Tableau de bord
                                </span>
                            </Link>
                            <button className="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-300">
                                <Edit className="h-4 w-4" />
                                <span className="text-sm font-medium">
                                    Modifier
                                </span>
                            </button>
                            <button className="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-300">
                                <Megaphone className="h-4 w-4" />
                                <span className="text-sm font-medium">
                                    Promouvoir
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                {/* Tabs Navigation */}
                <div className="bg-white border-b border-gray-200">
                    <div className="px-6">
                        <Tabs
                            value={currentTab}
                            onValueChange={handleTabChange}
                            className="w-full"
                        >
                            <TabsList className="grid w-full grid-cols-5 rounded-none shadow-none px-0 h-auto border-gray-200 bg-transparent">
                                {Object.entries(tabs).map(([key, tab]) => {
                                    const IconComponent = iconMap[tab.icon];
                                    return (
                                        <TabsTrigger
                                            key={key}
                                            value={key}
                                            className={cn(
                                                "group flex flex-col bg-transparent items-center justify-center p-4 data-[state=active]:shadow-none data-[state=active]:bg-transparent data-[state=active]:border-b-2 data-[state=active]:border-primary data-[state=active]:text-primary transition-colors rounded-none",
                                                "text-gray-500 hover:text-primary hover:bg-gray-50"
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
                        </Tabs>
                    </div>
                </div>

                {/* Tab Content */}
                <div className="py-6">
                    <Tabs value={currentTab} className="w-full">
                        {Object.keys(tabs).map((tabKey) => (
                            <TabsContent key={tabKey} value={tabKey}>
                                {renderTabContent(tabKey)}
                            </TabsContent>
                        ))}
                    </Tabs>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
