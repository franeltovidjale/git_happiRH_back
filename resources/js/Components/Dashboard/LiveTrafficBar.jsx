export default function LiveTrafficBar({ trafficCount = 430 }) {
    return (
        <div className="p-3 mb-3 rounded-lg bg-primary">
            <div className="flex items-center text-white">
                <div className="flex items-center space-x-2">
                    <div className="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <span className="text-sm font-medium">
                        Trafic en direct: {trafficCount}
                    </span>
                </div>
            </div>
        </div>
    );
}
