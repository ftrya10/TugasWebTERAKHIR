import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="flex min-h-screen flex-col items-center justify-center bg-slate-900 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-800 via-slate-900 to-slate-950 p-6">
            <div className="z-10 mb-8">
                <Link href="/" className="flex flex-col items-center group">
                    <div className="p-4 rounded-2xl bg-slate-800/50 backdrop-blur-md border border-slate-700/50 shadow-xl group-hover:border-emerald-500/50 transition-all duration-300">
                        <ApplicationLogo className="h-16 w-16 fill-current text-emerald-400 group-hover:text-emerald-300 transition-colors" />
                    </div>
                    <h1 className="mt-4 text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-cyan-400">
                        Global Supply Chain
                    </h1>
                </Link>
            </div>

            <div className="z-10 w-full overflow-hidden bg-slate-800/40 backdrop-blur-xl border border-slate-700/60 px-8 py-10 shadow-2xl sm:max-w-md sm:rounded-2xl">
                {children}
            </div>
            
            {/* Ambient Background Glows */}
            <div className="absolute top-0 right-0 -z-0 h-[500px] w-[500px] rounded-full bg-emerald-500/10 blur-[100px] mix-blend-screen pointer-events-none"></div>
            <div className="absolute bottom-0 left-0 -z-0 h-[400px] w-[400px] rounded-full bg-cyan-500/10 blur-[100px] mix-blend-screen pointer-events-none"></div>
        </div>
    );
}
