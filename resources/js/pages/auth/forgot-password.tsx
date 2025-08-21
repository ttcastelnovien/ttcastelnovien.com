// Components
import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';

export default function ForgotPassword({ status }: { status?: string }) {
	const { data, setData, post, processing, errors, reset } = useForm<Required<{ username: string }>>({
		username: '',
	});

	const submit: FormEventHandler = (e) => {
		e.preventDefault();

		post(route('password.email'), {
			onFinish: () => reset('username'),
		});
	};

	return (
		<AuthLayout title="Mot de passe oublié" description="Entre ton nom d'utilisateur pour recevoir un lien de réinitialisation de mot de passe.">
			<Head title="Mot de passe oublié" />

			{status && <div className="mb-4 text-center text-sm font-medium text-green-600">{status}</div>}

			<div className="space-y-6">
				<form onSubmit={submit}>
					<div className="grid gap-2">
						<Label htmlFor="username">Nom d'utilisateur</Label>
						<Input
							id="username"
							type="text"
							name="username"
							autoComplete="off"
							value={data.username}
							autoFocus
							onChange={(e) => setData('username', e.target.value)}
							placeholder="prenom.nom"
						/>

						<InputError message={errors.username} />
					</div>

					<div className="my-6 flex items-center justify-start">
						<Button className="w-full" disabled={processing}>
							{processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
							Recevoir le lien de réinitialisation
						</Button>
					</div>
				</form>

				<div className="space-x-1 text-center text-sm text-muted-foreground">
					<span>ou retourner à la</span>
					<TextLink href={route('login')}>connexion</TextLink>
				</div>
			</div>
		</AuthLayout>
	);
}
