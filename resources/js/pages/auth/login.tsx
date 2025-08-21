import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';

type LoginForm = {
	username: string;
	password: string;
	remember: boolean;
};

export default function Login() {
	const { data, setData, post, processing, errors, reset } = useForm<Required<LoginForm>>({
		username: '',
		password: '',
		remember: false,
	});

	const submit: FormEventHandler = (e) => {
		e.preventDefault();
		post(route('login'), {
			onFinish: () => reset('password'),
		});
	};

	return (
		<AuthLayout title="Connexion" description="Entre ton nom d'utilisateur et ton mot de passe pour accéder à la plateforme">
			<Head title="Log in" />

			<form className="flex flex-col gap-6" onSubmit={submit}>
				<div className="grid gap-6">
					<div className="grid gap-2">
						<Label htmlFor="username">Nom d'utilisateur</Label>
						<Input
							id="username"
							type="text"
							required
							autoFocus
							tabIndex={1}
							value={data.username}
							onChange={(e) => setData('username', e.target.value)}
							placeholder="felix.lebrun"
						/>
						<InputError message={errors.username} />
					</div>

					<div className="grid gap-2">
						<div className="flex items-center">
							<Label htmlFor="password">Mot de passe</Label>
							<TextLink href={route('password.request')} className="ml-auto text-sm" tabIndex={5}>
								Mot de passe oublié ?
							</TextLink>
						</div>
						<Input
							id="password"
							type="password"
							required
							tabIndex={2}
							autoComplete="current-password"
							value={data.password}
							onChange={(e) => setData('password', e.target.value)}
						/>
						<InputError message={errors.password} />
					</div>

					<div className="flex items-center space-x-3">
						<Checkbox
							id="remember"
							name="remember"
							checked={data.remember}
							onClick={() => setData('remember', !data.remember)}
							tabIndex={3}
						/>
						<Label htmlFor="remember">Se souvenir de moi</Label>
					</div>

					<Button type="submit" size="lg" className="mt-4 w-full" tabIndex={4} disabled={processing}>
						{processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
						Se connecter
					</Button>
				</div>
			</form>
		</AuthLayout>
	);
}
