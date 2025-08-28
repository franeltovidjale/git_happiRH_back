import { Avatar, AvatarImage, AvatarFallback } from "@/Components/ui/avatar";
import { Separator } from "@/Components/ui/separator";
import {
    MapPin,
    Star,
    StarHalf,
    UserCheck,
    Phone,
    Mail,
    Globe,
    BanIcon,
    X,
    Building2,
    Calendar,
    Users,
    TrendingUp,
    Shield,
    CheckCircle,
    AlertCircle,
} from "lucide-react";

export default function EnterpriseDetails({ enterprise }) {
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

    return (
        <div className="w-full">
            {/* Content Grid */}
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {/* Contact Information Card */}
                <div className="lg:col-span-2">
                    <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div className="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <h2 className="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <Phone className="h-5 w-5 text-primary" />
                                Informations de Contact
                            </h2>
                        </div>
                        <div className="p-6">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div className="space-y-4">
                                    <div className="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                        <div className="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                            <Phone className="h-5 w-5 text-primary" />
                                        </div>
                                        <div>
                                            <p className="text-sm text-gray-500 font-medium">
                                                Téléphone
                                            </p>
                                            <p className="text-gray-900 font-semibold">
                                                {enterprise.phone ||
                                                    "Non renseigné"}
                                            </p>
                                        </div>
                                    </div>

                                    <div className="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                        <div className="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                            <Mail className="h-5 w-5 text-primary" />
                                        </div>
                                        <div>
                                            <p className="text-sm text-gray-500 font-medium">
                                                Email
                                            </p>
                                            <p className="text-gray-900 font-semibold">
                                                {enterprise.email ||
                                                    "Non renseigné"}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div className="space-y-4">
                                    <div className="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                        <div className="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                            <Globe className="h-5 w-5 text-primary" />
                                        </div>
                                        <div>
                                            <p className="text-sm text-gray-500 font-medium">
                                                Site Web
                                            </p>
                                            <p className="text-gray-900 font-semibold">
                                                {enterprise.website ||
                                                    "Non renseigné"}
                                            </p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                        <div className="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center mt-1">
                                            <MapPin className="h-5 w-5 text-primary" />
                                        </div>
                                        <div>
                                            <p className="text-sm text-gray-500 font-medium">
                                                Adresse
                                            </p>
                                            <p className="text-gray-900 font-semibold">
                                                {enterprise.address ||
                                                    "Non renseigné"}
                                            </p>
                                            <p className="text-gray-600 text-sm">
                                                {enterprise.zip_code ||
                                                    "Non renseigné"}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Stats & Details Card */}
                <div className="space-y-6">
                    {/* Status Card */}
                    <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div className="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <h3 className="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <Shield className="h-5 w-5 text-primary" />
                                Statut & Détails
                            </h3>
                        </div>
                        <div className="p-6 space-y-4">
                            <div className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span className="text-sm text-gray-600 font-medium">
                                    Statut
                                </span>
                                <div
                                    className={`flex items-center gap-2 px-3 py-1 rounded-full ${getStatusColor(
                                        enterprise.status
                                    )}/10 border border-${getStatusColor(
                                        enterprise.status
                                    )}/20`}
                                >
                                    {getStatusIcon(enterprise.status)}
                                    <span className="text-sm font-semibold capitalize">
                                        {enterprise.status}
                                    </span>
                                </div>
                            </div>

                            <div className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span className="text-sm text-gray-600 font-medium">
                                    IFU
                                </span>
                                <span className="text-sm font-semibold text-gray-900">
                                    {enterprise.ifu || "Non renseigné"}
                                </span>
                            </div>

                            <div className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span className="text-sm text-gray-600 font-medium">
                                    Code
                                </span>
                                <span className="text-sm font-semibold text-gray-900">
                                    {enterprise.code}
                                </span>
                            </div>

                            <div className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span className="text-sm text-gray-600 font-medium">
                                    Actif
                                </span>
                                <div
                                    className={`flex items-center gap-2 px-3 py-1 rounded-full ${
                                        enterprise.active
                                            ? "bg-emerald-500/10 border border-emerald-500/20"
                                            : "bg-red-500/10 border border-red-500/20"
                                    }`}
                                >
                                    {enterprise.active ? (
                                        <CheckCircle className="h-4 w-4 text-emerald-600" />
                                    ) : (
                                        <X className="h-4 w-4 text-red-600" />
                                    )}
                                    <span className="text-sm font-semibold">
                                        {enterprise.active ? "Oui" : "Non"}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
