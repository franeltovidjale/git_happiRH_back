import { useState } from "react";
import { Link, router } from "@inertiajs/react";
import {
    LayoutDashboard,
    Building,
    BarChart2,
    Users,
    UserCheck,
    UserX,
    Settings,
    Bell,
    HelpCircle,
    User,
    ChevronDown,
    LogOut,
} from "lucide-react";
import Dropdown from "@/Components/Dropdown";
import ApplicationLogo from "@/Components/ApplicationLogo";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";

// Composant pour un élément de menu
const SidebarItem = ({ icon: Icon, text, active, href, onClick }) => {
    const Component = href ? Link : "div";
    const props = href ? { href } : { onClick };

    return (
        <Component
            {...props}
            className={`
        flex items-center space-x-3 p-2.5 rounded-lg text-sm transition-colors duration-200 cursor-pointer
        ${
            active
                ? "bg-primary text-white font-semibold"
                : "text-gray-500 hover:bg-primary hover:text-white"
        }
      `}
        >
            <Icon className="w-5 h-5" />
            <span>{text}</span>
        </Component>
    );
};

// Composant pour un titre de section
const SidebarSectionTitle = ({ title }) => {
    return (
        <h3 className="pl-2 mt-6 mb-2 text-xs font-semibold tracking-wider text-gray-400 uppercase">
            {title}
        </h3>
    );
};

export default function Authenticated({ user, children }) {
    return (
        <div className="flex min-h-screen font-sans bg-gray-100">
            {/* Sidebar */}
            <div className="flex-shrink-0 p-4 m-4 w-48 bg-white rounded-3xl shadow-lg">
                {/* Logo */}
                <ApplicationLogo className="w-10 h-10" />

                {/* Liens de menu principaux */}
                <nav className="mt-8 space-y-1">
                    <SidebarItem
                        icon={LayoutDashboard}
                        text="Tableau de bord"
                        active={route().current("dashboard")}
                        href={route("dashboard")}
                    />
                    <SidebarItem
                        icon={Building}
                        text="Entreprises"
                        active={route().current("enterprises.index")}
                        href={route("enterprises.index")}
                    />
                </nav>

                {/* Section Statistiques */}
                <SidebarSectionTitle title="Statistiques" />
                <nav className="space-y-1">
                    <SidebarItem
                        icon={BarChart2}
                        text="Graphiques"
                        active={false}
                    />
                    <SidebarItem
                        icon={BarChart2}
                        text="Rapports"
                        active={false}
                    />
                </nav>

                {/* Section Utilisateurs */}
                <SidebarSectionTitle title="Utilisateurs" />
                <nav className="space-y-1">
                    <SidebarItem
                        icon={UserCheck}
                        text="Administrateurs"
                        active={false}
                    />
                    <SidebarItem
                        icon={Building}
                        text="Employeurs"
                        active={false}
                    />
                    <SidebarItem icon={Users} text="Employés" active={false} />
                </nav>

                {/* Section Paramètres */}
                <SidebarSectionTitle title="Paramètres" />
                <nav className="space-y-1">
                    <SidebarItem
                        icon={Settings}
                        text="Configuration"
                        active={false}
                    />
                    <SidebarItem
                        icon={Bell}
                        text="Notifications"
                        active={false}
                    />
                    <SidebarItem icon={HelpCircle} text="Aide" active={false} />
                    <SidebarItem
                        icon={User}
                        text="Profil"
                        active={route().current("profile.edit")}
                        href={route("profile.edit")}
                    />
                </nav>

                {/* User dropdown for mobile */}
                <div className="mt-6 sm:hidden">
                    <div className="pt-4 pb-1 border-t border-gray-200">
                        <div className="px-2">
                            <div className="text-base font-medium text-gray-800">
                                {user.name}
                            </div>
                            <div className="text-sm font-medium text-gray-500">
                                {user.email}
                            </div>
                        </div>
                        <div className="mt-3 space-y-1">
                            <SidebarItem
                                icon={User}
                                text="Profil"
                                active={route().current("profile.edit")}
                                href={route("profile.edit")}
                            />
                            <SidebarItem
                                icon={LogOut}
                                text="Se déconnecter"
                                active={false}
                                href={route("logout")}
                                onClick={(e) => {
                                    e.preventDefault();
                                    router.post(route("logout"));
                                }}
                            />
                        </div>
                    </div>
                </div>
            </div>

            {/* Main content area */}
            <div className="flex flex-col flex-1 m-4">
                {/* Dashboard Header */}
                <header className="bg-white rounded-3xl border-b border-gray-100 shadow-sm">
                    <div className="px-6 py-4">
                        <div className="flex justify-between items-center">
                            {/* Breadcrumb */}
                            <div className="flex items-center space-x-2">
                                <h1 className="text-2xl font-bold text-gray-800">
                                    Tableau de bord
                                </h1>
                            </div>

                            {/* Right side icons */}
                            <div className="flex items-center space-x-3">
                                {/* Notification icon */}
                                <button className="relative p-2 text-gray-500 rounded-lg transition-colors hover:text-gray-700 hover:bg-gray-100">
                                    <Bell className="w-5 h-5" />
                                    <span className="flex absolute -top-1 -right-1 z-10 justify-center items-center w-5 h-5 text-xs font-medium text-white bg-orange-500 rounded-full">
                                        3
                                    </span>
                                </button>

                                {/* Profile dropdown */}
                                <DropdownMenu>
                                    <DropdownMenuTrigger asChild>
                                        <button className="flex items-center p-2 space-x-2 text-gray-500 rounded-lg transition-colors hover:text-gray-700 hover:bg-gray-100">
                                            <Avatar className="w-5 h-5">
                                                <AvatarImage
                                                    src={user.profile_photo_url}
                                                    alt={user.name}
                                                />
                                                <AvatarFallback className="text-xs font-medium text-white bg-primary">
                                                    {user.name
                                                        ? user.name
                                                              .charAt(0)
                                                              .toUpperCase()
                                                        : "U"}
                                                </AvatarFallback>
                                            </Avatar>
                                            <ChevronDown className="w-4 h-4" />
                                        </button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent
                                        className="w-56"
                                        align="end"
                                        forceMount
                                    >
                                        <DropdownMenuLabel className="font-normal">
                                            <div className="flex flex-col space-y-1">
                                                <p className="text-sm font-medium leading-none">
                                                    {user.name}
                                                </p>
                                                <p className="text-xs leading-none text-muted-foreground">
                                                    {user.email}
                                                </p>
                                            </div>
                                        </DropdownMenuLabel>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuItem asChild>
                                            <Link
                                                href={route("profile.edit")}
                                                className="cursor-pointer"
                                            >
                                                <User className="mr-2 w-4 h-4" />
                                                <span>Profil</span>
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem asChild>
                                            <Link
                                                href={route("logout")}
                                                method="post"
                                                as="button"
                                                className="w-full cursor-pointer"
                                            >
                                                <LogOut className="mr-2 w-4 h-4" />
                                                <span>Se déconnecter</span>
                                            </Link>
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        </div>
                    </div>
                </header>

                <main className="flex-1">{children}</main>
            </div>
        </div>
    );
}
