import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import {
    Eye,
    Clock,
    Smile,
    Magnet,
    Filter,
    ChevronDown,
    Building,
} from "lucide-react";
import {
    MetricCard,
    LiveTrafficBar,
    VisitsChart,
} from "@/Components/Dashboard";

export default function Dashboard({ auth }) {
    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Dashboard" />

            <div className="mt-3">
                {/* Filters and Controls */}
                <div className="flex justify-between items-center mb-3">
                    <div></div> {/* Empty div for spacing */}
                    <div className="flex items-center space-x-3">
                        <button className="flex items-center space-x-2 px-3 py-1.5 bg-primary-50 border border-primary-200 rounded-lg text-gray-700 hover:bg-primary-100 transition-colors">
                            <Filter className="w-4 h-4" />
                            <span className="text-sm font-medium">Filter</span>
                        </button>

                        {/* Date Range Selection */}
                        <div className="flex items-center space-x-1">
                            <button className="px-3 py-1.5 bg-primary border border-primary rounded-lg text-white text-sm font-medium shadow-sm">
                                24H
                            </button>
                            <button className="px-3 py-1.5 bg-primary-50 border border-primary-200 rounded-lg text-gray-700 text-sm font-medium hover:bg-primary hover:text-white hover:border-primary transition-colors">
                                Today
                            </button>
                            <button className="px-3 py-1.5 bg-primary-50 border border-primary-200 rounded-lg text-gray-700 text-sm font-medium hover:bg-primary hover:text-white hover:border-primary transition-colors">
                                7D
                            </button>
                            <button className="px-3 py-1.5 bg-primary-50 border border-primary-200 rounded-lg text-gray-700 text-sm font-medium hover:bg-primary hover:text-white hover:border-primary transition-colors">
                                30D
                            </button>
                            <button className="px-3 py-1.5 bg-primary-50 border border-primary-200 rounded-lg text-gray-700 text-sm font-medium hover:bg-primary hover:text-white hover:border-primary transition-colors">
                                90D
                            </button>
                            <button className="px-3 py-1.5 bg-primary-50 border border-primary-200 rounded-lg text-gray-700 text-sm font-medium hover:bg-primary hover:text-white hover:border-primary transition-colors">
                                1 Year
                            </button>
                            <button className="px-3 py-1.5 bg-primary-50 border border-primary-200 rounded-lg text-gray-700 text-sm font-medium hover:bg-primary hover:text-white hover:border-primary transition-colors">
                                Custom
                            </button>
                        </div>

                        <button className="flex items-center space-x-2 px-3 py-1.5 bg-primary-50 border border-primary-200 rounded-lg text-gray-700 hover:bg-primary-100 transition-colors">
                            <span className="text-sm font-medium">
                                Saved Filters
                            </span>
                            <ChevronDown className="w-4 h-4" />
                        </button>
                    </div>
                </div>

                {/* Live Traffic Bar */}
                <LiveTrafficBar />

                {/* Metric Cards */}
                <div className="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                    <MetricCard
                        icon={Eye}
                        title="Trafic"
                        reachText="Reach up"
                        percentage="0%"
                        primaryValue="905"
                        primaryLabel="Visites"
                        secondaryValue="900"
                        secondaryLabel="Utilisateurs"
                    />
                    <MetricCard
                        icon={Clock}
                        title="Durée d'activité"
                        reachText="Reach down"
                        percentage="0%"
                        primaryValue="100"
                        primaryLabel="Visites"
                        secondaryValue="700"
                        secondaryLabel="Utilisateurs"
                    />
                    <MetricCard
                        icon={Building}
                        title="Entreprises"
                        reachText="Total"
                        percentage="+12%"
                        primaryValue="156"
                        primaryLabel="Entreprises"
                    />
                    <MetricCard
                        icon={Smile}
                        title="Visite moyenne"
                        reachText="Reach down"
                        percentage="0%"
                        primaryValue="900"
                        primaryLabel="Visites"
                    />
                    <MetricCard
                        icon={Magnet}
                        title="Interaction champ"
                        reachText="Reach down"
                        percentage="0%"
                        primaryValue="1000"
                        primaryLabel="Visites"
                    />
                </div>

                {/* Statistics Chart */}
                <VisitsChart />
            </div>
        </AuthenticatedLayout>
    );
}
