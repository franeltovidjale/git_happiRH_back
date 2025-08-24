import { usePage } from "@inertiajs/react";

export default function ApplicationLogo(props) {
    const { shared } = usePage().props;
    const settings = shared?.settings || {};

    return (
        <div className="flex items-center space-x-3">
            {settings.logoPath ? (
                <img
                    src={settings.logoPath}
                    alt={settings.appName || "Logo"}
                    className="object-contain w-10 h-10"
                    {...props}
                />
            ) : (
                <></>
            )}
            <span className="text-2xl font-bold text-primary">
                {settings.appName || "HAPPIRH"}
            </span>
        </div>
    );
}
