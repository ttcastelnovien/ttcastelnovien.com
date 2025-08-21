import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';

interface ResetPasswordProps {
	token: string;
	username: string;
}

type ResetPasswordForm = {
	token: string;
	username: string;
	password: string;
	password_confirmation: string;
};

export default function ResetPassword({ token, username }: ResetPasswordProps) {
	const { data, setData, post, processing, errors, reset } = useForm<Required<ResetPasswordForm>>({
		token: token,
		username: username,
		password: '',
		password_confirmation: '',
	});

	const submit: FormEventHandler = (e) => {
		e.preventDefault();
		post(route('password.store'), {
			onFinish: () => reset('password', 'password_confirmation'),
		});
	};

	return (
		<AuthLayout title="Réinitialisation du mot de passe" description="Merci d'entrer un nouveau mot de passe pour ton compte.">
			<Head title="Réinitialisation du mot de passe" />

			<form onSubmit={submit}>
				<div className="grid gap-6">
					<div className="grid gap-2">
						<Label htmlFor="username">Nom d'utilisateur</Label>
						<Input id="username" type="text" name="username" value={data.username} className="mt-1 block w-full" readOnly />
						<InputError message={errors.username} className="mt-2" />
					</div>

					<div className="grid gap-2">
						<Label htmlFor="password">Nouveau mot de passe</Label>
						<Input
							id="password"
							type="password"
							name="password"
							autoComplete="new-password"
							value={data.password}
							className="mt-1 block w-full"
							autoFocus
							onChange={(e) => setData('password', e.target.value)}
						/>
						<InputError message={errors.password} />
					</div>

					<div className="grid gap-2">
						<Label htmlFor="password_confirmation">Confirme le nouveau mot de passe</Label>
						<Input
							id="password_confirmation"
							type="password"
							name="password_confirmation"
							autoComplete="new-password"
							value={data.password_confirmation}
							className="mt-1 block w-full"
							onChange={(e) => setData('password_confirmation', e.target.value)}
						/>
						<InputError message={errors.password_confirmation} className="mt-2" />
					</div>

					<Button type="submit" className="mt-4 w-full" disabled={processing}>
						{processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
						Réinitialiser mon mot de passe
					</Button>
				</div>
			</form>
		</AuthLayout>
	);
}
