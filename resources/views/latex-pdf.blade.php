%% file homework-2024.tex

\documentclass[a4paper]{article}

\usepackage{a4wide}
\usepackage{amsmath}
\usepackage{amssymb}
\usepackage{enumerate}
\usepackage{tikz}

\usetikzlibrary{arrows,automata}

\begin{document}

\tikzset{%%
every picture/.style={
->, >=stealth', shorten >=0.5pt,  auto, inner sep=2pt,
node distance=2.8cm, semithick, initial text=, double distance=1.25pt},
every state/.style={
circle, minimum size=15pt, inner sep=1pt, draw},
every loop/.style={
min distance=12.5mm},
} %%

\setlength{\parskip}{0.5em}
\setlength{\parindent}{0cm}
\large

\newcommand{\Connect}{\textsc{connect}}
\newcommand{\Mid}{\textsc{mid}}
\newcommand{\Partition}{\mathit{PARTITION}}
\newcommand{\SAT}{\mathit{SAT}}
\newcommand{\SubsetSum}{\mathit{SUBSET} \mbox{-} \mathit{SUM}}
\newcommand{\DominatingSet}{\mathit{DOMINATING} \mbox{-} \mathit{SET}}
\newcommand{\VertexCover}{\mathit{VERTEX} \mbox{-} \mathit{COVER}}

\newcommand{\calL}{\mathcal{L}}
\newcommand{\calP}{\mathcal{P}}
\newcommand{\calS}{\mathcal{S}}
\newcommand{\code}[1]{\langle {#1} \rangle}
\newcommand{\eps}{\varepsilon}
\newcommand{\false}{\mathit{false}}
\newcommand{\lc}{\lbrace \,}
\newcommand{\lpshuffle}{\mathop{\parallel_{\ell p}}}
\newcommand{\pair}[2]{\langle {#1}, \mkern-1mu {#2} \rangle}
\newcommand{\qsubf}{q_{\mkern-2mu f}}
\newcommand{\rc}{\, \rbrace}
\newcommand{\true}{\mathit{true}}
\newcommand{\singleton}[1]{\lbrace {#1} \rbrace}
\newcommand{\xbar}{\bar{x}}


\paragraph{Automaton engineering}
For a language $L \subseteq \Sigma^\ast$, for some
alphabet~$\Sigma$, the language $\Mid(L)$
is given by
\begin{displaymath}
\Mid(L) =
\lbrace \, w \in \Sigma^\ast \mid
\exists \mkern1mu x,y \in \Sigma^\ast \colon
x \mkern0.5mu wy \in L
\, \rbrace \mkern1mu .
\end{displaymath}
Thus, $\Mid(L)$ consists of strings from~$L$, with some (possibly
empty) beginning and ending missing. Prove that $\Mid(L)$ is a
regular language if $L$~is a regular language.

\medskip

(Hint: Construct from a DFA~$D$ for~$L$ an NFA~$N$ for
$\Mid(L)$. The NFA~$N$ makes proper jumps from its new starting
state and proper jumps into its new accepting state. Next, show that
$\calL(N) = \Mid(L)$.)
\paragraph{Answer:}
Suppose DFA D = (Q,$\Sigma$,$\delta$,$q_0$,F) recognizes L. Define NFA N = ($Q'$,$\Sigma$,$\delta'$,p,$\{r\}$) that recognizes MID(L). \\
\textit{Define}:\\
$Q'$ = Q $\cup \{p,r\}$\\
$\delta'$(p,a) = $\emptyset$ for all $q \in Q, a \in \Sigma$\\
$\delta'$(q,a) = $\{\delta(q,a)\}$\\
$\delta'$(r,a) = $\emptyset$\\
$\delta'$(p,$\epsilon$) = $\{q\in Q | \exists x\in \Sigma*: (q_0,x) \vdash^*_D (q,\epsilon) \}$\\
$\delta'$(q,$\epsilon$) =
\\
$\delta'$(r,$\epsilon$) = $\emptyset$ for all $q \in Q, a \in \Sigma$\\\\

We have to prove that L(N) = MID(L)!\\

w $\in \mathcal{L}(N)$\\
$\iff (p, w) \vdash^*_N (r, \varepsilon) \quad \text{(definition of $\mathcal{L}(N)$)}$\\
$\iff \exists q, q' \in Q: (p, w) \vdash_N (q, w) \vdash^*_N (q', \epsilon) \vdash_N (r, \epsilon) \quad \text{(property of $N$)}$\\
$\iff \exists q, q' \in Q: \exists x \in \Sigma^*: (q_0, x) \vdash^*_D (q, \epsilon) \land (q, w) \vdash^*_D (q', \epsilon) \land
\exists q_f \in F \exists y \in \Sigma^*: (q', y) \vdash^*_D (q_f, \epsilon) \quad \text{(definition of $N$)}$\\
$\iff \exists q, q' \in Q \exists q_f \in F \exists x, y \in \Sigma^*: (q_0, xwy) \vdash^*_D (q, wy) \vdash^*_D (q', y) \vdash^*_D (q_f, \epsilon) \quad \text{(property of $\vdash_D$)}$\\
$\iff \exists q_f \in F \exists x, y \in \Sigma^*: (q_0, xwy) \vdash^*_D (q_f, \epsilon) \quad \text{(property of $\vdash_D$)}$\\
$\iff \exists x, y \in \Sigma^*: xwy \in \mathcal{L}(D) \quad \text{(definition of $\mathcal{L}(D)$)}$\\
$\iff \exists x, y \in \Sigma^*: xwy \in L$\\
$\iff w \in \operatorname{MID}(L) \quad \text{(definition of $\operatorname{MID}(L)$)}$\\

We have proved our claim
\end{document}

