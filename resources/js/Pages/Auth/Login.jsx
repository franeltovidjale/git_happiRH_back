import { useState, useEffect } from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import { Eye, EyeOff, ChevronRight } from "lucide-react";

export default function Login({ status, canResetPassword, settings }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: false,
    });

    const [showPassword, setShowPassword] = useState(false);
    const [currentTime, setCurrentTime] = useState(new Date());

    useEffect(() => {
        const timer = setInterval(() => {
            setCurrentTime(new Date());
        }, 1000);
        return () => clearInterval(timer);
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route("login"), {
            onFinish: () => reset("password"),
        });
    };

    const formatTime = (date) => {
        return date.toLocaleTimeString("fr-FR", {
            hour: "2-digit",
            minute: "2-digit",
        });
    };

    const formatDate = (date) => {
        return date.toLocaleDateString("fr-FR", {
            weekday: "long",
            day: "numeric",
            month: "long",
            year: "numeric",
        });
    };

    return (
        <div className="flex min-h-screen bg-gradient-to-br from-blue-50 to-purple-50">
            {/* Left panel - decorative */}
            <div className="hidden overflow-hidden relative bg-gradient-to-br from-blue-600 to-purple-700 lg:flex lg:w-1/2">
                <div className="absolute inset-0 opacity-10 bg-pattern"></div>
                <div className="flex relative z-10 flex-col justify-between p-12 h-full text-white">
                    <div>
                        <h1 className="mb-2 text-4xl font-light">
                            {settings?.title || "HAPPIRH"}
                        </h1>
                        <p className="text-xl font-extralight opacity-80">
                            {settings?.slogan || "Gestion RH Simplifiée"}
                        </p>
                    </div>

                    <div className="space-y-8">
                        <div className="space-y-1">
                            <p className="text-6xl font-extralight">
                                {formatTime(currentTime)}
                            </p>
                            <p className="text-lg font-light capitalize opacity-70">
                                {formatDate(currentTime)}
                            </p>
                        </div>

                        <div className="space-y-1">
                            <p className="text-xl font-light">
                                Gestion RH intelligente
                            </p>
                            <p className="text-sm font-light opacity-70">
                                Gérez vos employés et ressources humaines en
                                toute simplicité
                            </p>
                        </div>
                    </div>
                </div>

                {/* Decorative circles */}
                <div className="absolute right-0 bottom-0 w-96 h-96 bg-purple-500 rounded-full opacity-20 translate-x-1/3 translate-y-1/3"></div>
                <div className="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full opacity-20 -translate-x-1/3 -translate-y-1/3"></div>
            </div>

            {/* Right panel - login form */}
            <div className="flex justify-center items-center p-6 w-full lg:w-1/2">
                <div className="w-full max-w-md">
                    <Head title="Connexion" />

                    <div className="mb-10 text-center">
                        {settings?.logo && (
                            <img
                                src={settings.logo}
                                alt={settings?.title || "Logo"}
                                className="mx-auto mb-6 w-auto h-20"
                            />
                        )}
                        <h2 className="mb-2 text-3xl font-light text-gray-800">
                            Bienvenue sur HAPPIRH
                        </h2>
                        <p className="text-gray-500">
                            Connectez-vous à votre espace de gestion RH
                        </p>
                    </div>

                    {status && (
                        <div className="p-4 mb-6 text-sm text-green-700 bg-green-50 rounded-lg border-l-4 border-green-500">
                            {status}
                        </div>
                    )}

                    <div className="p-8 bg-white rounded-xl shadow-xl">
                        <form onSubmit={submit}>
                            <div className="mb-6">
                                <label
                                    htmlFor="email"
                                    className="block mb-1 text-sm font-medium text-gray-700"
                                >
                                    Adresse email
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    className="px-4 py-3 w-full rounded-lg border border-gray-300 transition-colors focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="nom@exemple.com"
                                    onChange={(e) =>
                                        setData("email", e.target.value)
                                    }
                                    autoFocus
                                />
                                {errors.email && (
                                    <p className="mt-1 text-sm text-red-600">
                                        {errors.email}
                                    </p>
                                )}
                            </div>

                            <div className="mb-6">
                                <div className="flex justify-between items-center mb-1">
                                    <label
                                        htmlFor="password"
                                        className="block text-sm font-medium text-gray-700"
                                    >
                                        Mot de passe
                                    </label>
                                    {canResetPassword && (
                                        <Link
                                            href={route("password.request")}
                                            className="text-xs transition-colors text-primary hover:text-primary/80"
                                        >
                                            Mot de passe oublié ?
                                        </Link>
                                    )}
                                </div>
                                <div className="relative">
                                    <input
                                        id="password"
                                        type={
                                            showPassword ? "text" : "password"
                                        }
                                        name="password"
                                        value={data.password}
                                        className="px-4 py-3 w-full rounded-lg border border-gray-300 transition-colors focus:ring-2 focus:ring-primary focus:border-primary"
                                        placeholder="••••••••"
                                        onChange={(e) =>
                                            setData("password", e.target.value)
                                        }
                                    />
                                    <button
                                        type="button"
                                        className="flex absolute inset-y-0 right-0 items-center pr-3 text-gray-500 hover:text-gray-600"
                                        onClick={() =>
                                            setShowPassword(!showPassword)
                                        }
                                    >
                                        {showPassword ? (
                                            <EyeOff className="w-5 h-5" />
                                        ) : (
                                            <Eye className="w-5 h-5" />
                                        )}
                                    </button>
                                </div>
                                {errors.password && (
                                    <p className="mt-1 text-sm text-red-600">
                                        {errors.password}
                                    </p>
                                )}
                            </div>

                            <div className="mb-8">
                                <label className="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        className="rounded border-gray-300 shadow-sm text-primary focus:border-primary/70 focus:ring focus:ring-primary/20 focus:ring-opacity-50"
                                        name="remember"
                                        checked={data.remember}
                                        onChange={(e) =>
                                            setData(
                                                "remember",
                                                e.target.checked
                                            )
                                        }
                                    />
                                    <span className="ml-2 text-sm text-gray-600">
                                        Se souvenir de moi
                                    </span>
                                </label>
                            </div>

                            <button
                                type="submit"
                                disabled={processing}
                                className="flex justify-center items-center px-6 py-3 w-full font-medium text-white bg-gradient-to-r from-blue-600 to-purple-700 rounded-lg transition-all hover:from-blue-700 hover:to-purple-800 disabled:opacity-70"
                            >
                                Accéder à l'espace RH
                                <ChevronRight className="ml-2 w-5 h-5" />
                            </button>
                        </form>
                    </div>

                    <div className="mt-8 text-center">
                        <p className="text-sm text-gray-600">
                            Vous n'avez pas de compte RH ?{" "}
                            <Link
                                href={route("register")}
                                className="font-medium transition-colors text-primary hover:text-primary/80 hover:underline"
                            >
                                Créer un compte employé
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}
